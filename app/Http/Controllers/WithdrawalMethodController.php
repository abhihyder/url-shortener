<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class WithdrawalMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(WithdrawalMethod::query()->where('user_id', Auth::user()->id))
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '<div class="btn-group" role="group" aria-label="Basic example">
                    <a href="' . route('withdrawal-method.edit', $row->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    </div>';
                    return $action;
                })
                ->editColumn('payment_method_id', function ($row) {
                    return $row->paymentMethod->name;
                })
                ->editColumn('country_id', function ($row) {
                    return $row->country->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('content.withdrawal.method.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_methods = PaymentMethod::all();
        $countries = Country::where('id', '>', 1)->get();
        return view('content.withdrawal.method.create', ['payment_methods' => $payment_methods, 'countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validation_rule = [
                'payment_method' => 'required',
                'withdrawal_account' => 'required',
                'first_name' => 'required|string',
                'address_1' => 'required|string',
                'country' => 'required',
            ];
            if ($request->payment_method == 1) {
                $validation_rule['withdrawal_account'] = 'required|email';
            }

            $validator = Validator::make($request->all(), $validation_rule);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            DB::beginTransaction();
            $withdrawal_method = new WithdrawalMethod();
            $withdrawal_method->user_id  = Auth::user()->id;
            $withdrawal_method->payment_method_id = $request->payment_method;
            $withdrawal_method->withdrawal_account = $request->withdrawal_account;
            $withdrawal_method->first_name = $request->first_name;
            $withdrawal_method->last_name = $request->last_name;
            $withdrawal_method->address_1 = $request->address_1;
            $withdrawal_method->address_2 = $request->address_2;
            $withdrawal_method->phone = $request->phone;
            $withdrawal_method->city = $request->city;
            $withdrawal_method->state = $request->state;
            $withdrawal_method->zip = $request->zip;
            $withdrawal_method->country_id = $request->country;
            $withdrawal_method->save();
            DB::commit();
            return $this->respondCreated('Withdrawal Method created successfully!', $withdrawal_method);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $withdrawal_method = WithdrawalMethod::where('user_id', Auth::user()->id)->findOrFail($id);
            $payment_methods = PaymentMethod::all();
            $countries = Country::where('id', '>', 1)->get();
            return view('content.withdrawal.method.edit', ['withdrawal_method' => $withdrawal_method, 'payment_methods' => $payment_methods, 'countries' => $countries]);
        } catch (\Exception $ex) {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validation_rule = [
                'payment_method' => 'required',
                'withdrawal_account' => 'required',
                'first_name' => 'required|string',
                'address_1' => 'required|string',
                'country' => 'required',
            ];
            
            if ($request->payment_method == 1) {
                $validation_rule['withdrawal_account'] = 'required|email';
            }

            $validator = Validator::make($request->all(), $validation_rule);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            DB::beginTransaction();
            $withdrawal_method = WithdrawalMethod::where('user_id', Auth::user()->id)->findOrFail($id);
            $withdrawal_method->payment_method_id = $request->payment_method;
            $withdrawal_method->withdrawal_account = $request->withdrawal_account;
            $withdrawal_method->first_name = $request->first_name;
            $withdrawal_method->last_name = $request->last_name;
            $withdrawal_method->address_1 = $request->address_1;
            $withdrawal_method->address_2 = $request->address_2;
            $withdrawal_method->phone = $request->phone;
            $withdrawal_method->city = $request->city;
            $withdrawal_method->state = $request->state;
            $withdrawal_method->zip = $request->zip;
            $withdrawal_method->country_id = $request->country;
            $withdrawal_method->save();
            DB::commit();
            return $this->respondCreated('Withdrawal Method updated successfully!', $withdrawal_method);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawalMethod $withdrawalMethod)
    {
        //
    }
}
