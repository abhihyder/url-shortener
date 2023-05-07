<?php

namespace App\Repositories\Services;

use App\Models\ReferralEarning;
use App\Models\ShortenUrl;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Wallet;
use App\Repositories\Interfaces\VisitorInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class VisitorFacadeService implements VisitorInterface
{
    public function visit(string $urlCode)
    {
        try {
            $shortenUrl = ShortenUrl::with('user')->where(['url_code' => $urlCode, 'status' => true])->firstOrFail();

            if ($shortenUrl->expire_date && $shortenUrl->expire_date < date('Y-m-d HH:mm:ss'))  return view('content.landing-page.error.404', ['message' => 'Opps... URL is expired!']);

            if ($shortenUrl->access_code)  return view('content.landing-page.password', ['url_code' => $shortenUrl->url_code]);

            $this->visitorLog($shortenUrl); // Insert visitor log
            return redirect()->to($shortenUrl->url);
        } catch (\Exception $ex) {
            return view('content.landing-page.error.404', ['message' => 'Opps... URL not found!']);
        }
    }

    public function accessCode(array $request)
    {
        try {
            $shortenUrl = ShortenUrl::with('user')->where(['url_code' => $request['url_code'], 'access_code' => $request['access_code'], 'status' => true])->firstOrFail();

            if ($shortenUrl->expire_date && $shortenUrl->expire_date < date('Y-m-d HH:mm:ss'))  return view('content.landing-page.error.404');

            $this->visitorLog($shortenUrl); // Insert visitor log
            return redirect()->to($shortenUrl->url);
        } catch (\Exception $ex) {
            return redirect()->back();
        }
    }

    public function datatables()
    {
        return DataTables::of($this->getQuery())
            ->addIndexColumn()
            ->addColumn('url_name', function ($row) {
                return $row->shortenUrl->name;
            })
            ->addColumn('url', function ($row) {
                return $row->shortenUrl->url;
            })
            ->addColumn('url_code', function ($row) {
                return route('visitor.visit', $row->shortenUrl->url_code);
            })
            ->editColumn('is_unique', function ($row) {
                $isUnique = '<span class="badge badge-danger">No</span>';
                if ($row->is_unique == 1)  $isUnique = '<span class="badge badge-success">Yes</span>';
                return $isUnique;
            })
            ->editColumn('created_at', function ($row) {
                return date('d M Y h:ia', strtotime($row->created_at));
            })
            ->editColumn('payment', function ($row) {
                return "$" . number_format($row->payment, 4);
            })
            ->rawColumns(['is_unique'])
            ->make(true);
    }

    private function getQuery()
    {
        return Visitor::query()->with('shortenUrl:id,name,url,url_code')
            ->when(request()->input('shorten_url_id'), function ($query) {
                $query->where('shorten_url_id', request()->input('shorten_url_id'));
            })
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc');
    }

    private function visitorLog($shortenUrl)
    {
        $attributes = [
            'user_id' => $shortenUrl->user_id,
            'shorten_url_id' => $shortenUrl->id,
            'payment' => 0,
            'is_unique' => false,
            'earning_disable' => $shortenUrl->user->earning_disable,
            'ip' => getIP(),
            'os' => getUserOS(),
            'browser' => getBrowserName(),
        ];

        //Fetch last unique visit-------
        $lastVisited = Visitor::where(['shorten_url_id' => $shortenUrl->id, 'ip' => $attributes['ip'], 'is_unique' => true])->latest()->first();

        if ($lastVisited) {
            $lastVisitedTime = Carbon::createFromFormat('Y-m-d H:i:s', $lastVisited->created_at);
            $diff = $lastVisitedTime->diffInMinutes(Carbon::now());
            $visitorTimeLimit = getAdminSetting('visitor_time_limit') ?? 720;
            if ($diff >= $visitorTimeLimit) {
                $attributes['is_unique'] = true;
                if ($attributes['earning_disable'] == false) {
                    $attributes['payment'] = getAdminSetting('payment_per_visit') ?? 0;
                }
                $this->createVisitorLog($attributes);
            } else {
                $this->createVisitorLog($attributes);
            }
        } else {
            $attributes['is_unique'] = true;
            if ($attributes['earning_disable'] == false) {
                $attributes['payment'] = getAdminSetting('payment_per_visit') ?? 0;
            }
            $this->createVisitorLog($attributes);
        }

        $this->updateWallet($shortenUrl, $attributes);
    }

    private function createVisitorLog(array $attributes)
    {
        Visitor::create($attributes);
    }

    private function updateWallet(ShortenUrl $shortenUrl, array $attributes)
    {
        $shortenUrl->increment('total_visit');
        if ($attributes['is_unique'] == true) {
            $shortenUrl->increment('unique_visit');
            if ($attributes['earning_disable'] == false) {
                Wallet::where('user_id', $shortenUrl->user_id)->first()->increment('available_balance', $attributes['payment']);

                if ($shortenUrl->user->referrer_id) $this->countAsReferral($shortenUrl->user, $attributes['payment']);
            }
        }
    }

    private function countAsReferral(User $user, $rate)
    {
        if ($user->referrer) {
            if ($user->referrer->earning_disable == false) {
                $referral_percentage = getAdminSetting('referral_percentage') ?? 0;
                $amount = valueByPercentage($rate, $referral_percentage);
                if ($amount > 0) {
                    $referralEarning = new ReferralEarning();
                    $referralEarning->referrer_id = $user->referrer_id;
                    $referralEarning->referred_id = $user->id;
                    $referralEarning->amount = $amount;
                    $referralEarning->percentage = $referral_percentage;
                    $referralEarning->rate = $rate;
                    $referralEarning->save();
                    Wallet::where('user_id', $user->referrer_id)->first()->increment('available_balance', $amount);
                }
            }
        }
    }
}
