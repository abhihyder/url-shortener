<?php

namespace App\Repositories\Services;

use App\Models\Banner;
use App\Repositories\Interfaces\BannerInterface;
use Hyder\JsonResponse\Facades\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BannerFacadeService implements BannerInterface
{
    public function datatables()
    {
        $banners = Banner::query()->with('user')->where(['user_id' => Auth::user()->id])->orderBy('id', 'desc');

        return DataTables::of($banners)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = '<a href="javascript:;" class="btn btn-primary btn-sm edit_banner_data"><i class="fas fa-edit"></i></a>';
                return $action;
            })
            ->addColumn('banner_img', function ($row) {
                return '<img src="' . asset($row->file_path) . '" alt="' . $row->name . '" height="70px" />';
            })
            ->editColumn('created_at', function ($row) {
                return date('d M Y h:ia', strtotime($row->created_at));
            })
            ->rawColumns(['banner_img', 'action'])
            ->make(true);
    }

    public function store(array $request)
    {
        try {
            $validator = $this->validation($request);

            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            $fileContent = $request['banner'] ?? null;
            $fileName = null;
            $filePath = null;
            $folder_structure = null;
            $disk_type = null;
            $auth_id = Auth::user()->id;
            if ($request['form_type'] == 'store') {
                $bannerCount = Banner::where('user_id', $auth_id)->count();
                if ($bannerCount >= 5) {
                    return JsonResponse::badRequest("You are not allowed to add more than 5 banner!");
                }
                $banner = new Banner();
                $banner->user_id =  $auth_id;
            } else {
                $banner = Banner::where('user_id', $auth_id)->findOrFail($request['banner_id']);
                $fileName = $banner->file_name;
                $filePath = $banner->file_path;
                $folder_structure = $banner->disk_prefix;
                $disk_type = $banner->disk_type;
            }

            if ($fileContent) {
                $response =  $this->bannerUpload($fileContent, $banner, $request, $auth_id);
                $fileName = $response['name'];
                $filePath = $response['path'];
            }

            $banner->name = $request['banner_name'];
            $banner->file_name = $fileName;
            $banner->file_path  = $filePath;
            $banner->disk_type  = $disk_type;
            $banner->disk_prefix  = $folder_structure;
            $banner->width  = $request['width'];
            $banner->height = $request['height'];
            $banner->save();
            return JsonResponse::success('Banner updated successfully!');
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    private function validation(array $request)
    {
        return Validator::make($request, [
            'banner_name' => 'required|string|max:64',
            'width' => 'required|string',
            'height' => 'required|string',
            'banner_id' => ($request['form_type'] == 'update') ? 'required' : '',
            'banner' => ($request['form_type'] == 'store' || $request['banner']) ? 'required|mimes:png,jpg,jpeg|max:1000' : '',
        ]);
    }

    private function bannerUpload($fileContent, $banner, $request, $auth_id)
    {
        $imgName = $auth_id . date("Ymd_His");
        $ext = strtolower($fileContent->getClientOriginalExtension());
        $fileName = $imgName . '.' . $ext;
        $folder_structure = 'storage/banners/' . date('Y/m/d');
        $filePath = $folder_structure . '/' . $fileName;
        $fileContent->move($folder_structure, $fileName);
        if ($request['form_type'] == 'update') {
            if ($banner->file_path) {
                if (File::exists($banner->file_path)) {
                    File::delete($banner->file_path);
                }
            }
        }

        return ['name' => $fileName, 'path' => $filePath];
    }
}
