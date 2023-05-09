<?php

namespace App\Repositories\Services;

use App\Models\ShortenUrl;
use App\Repositories\Facades\DirectoryFacade;
use App\Repositories\Interfaces\ShortenUrlInterface;
use Hyder\JsonResponse\Facades\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;

class ShortenUrlFacadeService implements ShortenUrlInterface
{
    public function index()
    {
        // TODO:
    }

    public function datatables()
    {
        return DataTables::of($this->getQuery())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group" role="group" aria-label="Basic example">
                <a href="javascript:;" class="btn btn-primary btn-sm" onclick="editShorten(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                </div>';
                return $action;
            })
            ->editColumn('user', function ($row) {
                return $row->user?->email;
            })
            ->editColumn('url_code', function ($row) {
                return '<div class="input-group">
                <input type="text" class="form-control" name="name" placeholder="Button on right" aria-describedby="button-addon2" value="' . route('visitor.visit', $row->url_code) . '"/>
                <div class="input-group-append" id="button-addon2">
                    <button class="btn btn-outline-secondary btn-sm copyLinkToClipBoard" type="button" data-link="' . route('visitor.visit', $row->url_code) . '"><i class="far fa-copy"></i></button>
                </div>
            </div>';
            })
            ->editColumn('created_at', function ($row) {
                return date('d M Y h:ia', strtotime($row->created_at));
            })
            ->editColumn('expire_date', function ($row) {
                $expireDate = '-';
                if ($row->expire_date)  $expireDate = date('d M Y h:ia', strtotime($row->expire_date));
                return $expireDate;
            })
            ->editColumn('status', function ($row) {
                $status = '<span class="badge badge-danger">Inactive</span>';
                if ($row->status == 1)  $status = '<span class="badge badge-success">Active</span>';
                return $status;
            })
            ->addColumn('total_visitor', function ($row) {
                return '<a href="' . route('visitor.index') . '?shorten_url_id=' . $row->id . '" target="_blank" class="btn btn-success btn-sm">' . count($row->visitors) . '</a>';
            })
            ->editColumn('qr_code_path', function ($row) {
                $qrCode = '';
                if ($row->qr_code_path) $qrCode = '<img width="60" src="' . url($row->qr_code_path) . '"/>';
                return $qrCode;
            })
            ->rawColumns(['action', 'status', 'total_visitor', 'url_code', 'qr_code_path'])
            ->make(true);
    }

    public function store(array $request)
    {
        try {
            $validator = $this->storeValidation($request);
            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            $urlCode = Str::random(8);
            $qrCodePath = $this->createQrCode(route('visitor.visit', $urlCode));
            ShortenUrl::create(array_merge($request, ['user_id' => Auth::id(), 'qr_code_path' => $qrCodePath, 'url_code' => $urlCode]));
            return JsonResponse::success('URL shortening done successfully!');
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    public function seed(array $request)
    {
        try {
            if (Config::get('app.env') == 'local') {
                $urlCode = Str::random(8);
                $qrCodePath = $this->createQrCode(route('visitor.visit', $urlCode));
                return ShortenUrl::create(array_merge($request, ['qr_code_path' => $qrCodePath, 'url_code' => $urlCode]));
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function find(int $id)
    {
        try {
            return JsonResponse::withData(ShortenUrl::findOrFail($id));
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    public function update(array $request)
    {
        $validator = $this->storeValidation($request);
        if ($validator->fails()) {
            return JsonResponse::invalidRequest($validator->errors());
        }

        ShortenUrl::find($request['id'])->update($request);
        return JsonResponse::success('URL shortening updated successfully!');
    }

    private function getQuery()
    {
        return ShortenUrl::query()->with('user:id,name,email', 'visitors:id,shorten_url_id')->where('user_id', Auth::id())->orderBy('id', 'desc');
    }

    private function createQrCode(string $qrCodeText)
    {
        $format = getAdminSetting('qr_code_format') ?? 'svg';

        $filePath = 'storage/qr/' . Str::random(20) . '.' . $format;

        DirectoryFacade::make(public_path($filePath));

        File::put(public_path($filePath), QrCode::format($format)->size(200)->generate($qrCodeText));

        return $filePath;
    }

    private function storeValidation(array $attributes)
    {
        return Validator::make($attributes, [
            'name' => 'required|string',
            'url' => 'required|string',
        ]);
    }
}
