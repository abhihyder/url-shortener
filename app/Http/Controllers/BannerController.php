<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = Banner::query()->with('user')->where(['user_id' => Auth::user()->id]);

            $banners->orderBy('id', 'desc');

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
        return view('content.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'banner_name' => 'required|string|max:64',
                'width' => 'required|string',
                'height' => 'required|string',
            ];

            if ($request->form_type == 'store' || $request->file('banner')) {
                $validation_rule['banner'] = 'required|mimes:png,jpg,jpeg|max:500';
            }

            $validator = Validator::make($request->all(), $validation_rule);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            $fileContent = $request->file('banner');
            $fileName = null;
            $filePath = null;
            $folder_structure = null;
            $disk_type = null;
            $auth_id = Auth::user()->id;
            if ($request->form_type == 'store') {
                $bannerCount = Banner::where('user_id', $auth_id)->count();
                if ($bannerCount >= 5) {
                    return $this->respondBadRequest("You are not allowed to add more than 5 banner!");
                }
                $banner = new Banner();
                $banner->user_id =  $auth_id;
            } else {
                $banner = Banner::where('user_id', $auth_id)->findOrFail($request->banner_id);
                $fileName = $banner->file_name;
                $filePath = $banner->file_path;
                $folder_structure = $banner->disk_prefix;
                $disk_type = $banner->disk_type;
            }

            if ($fileContent) {
                $imgName = $auth_id . date("Ymd_His");
                $ext = strtolower($fileContent->getClientOriginalExtension());
                $fileName = $imgName . '.' . $ext;
                $folder_structure = 'storage/banners/' . date('Y/m/d');
                $filePath = $folder_structure . '/' . $fileName;
                $fileContent->move($folder_structure, $fileName);
                if ($request->form_type == 'update') {
                    if ($banner->file_path) {
                        if (FacadesFile::exists($banner->file_path)) {
                            FacadesFile::delete($banner->file_path);
                        }
                    }
                }
            }

            DB::beginTransaction();
            $banner->name = $request->banner_name;
            $banner->file_name = $fileName;
            $banner->file_path  = $filePath;
            $banner->disk_type  = $disk_type;
            $banner->disk_prefix  = $folder_structure;
            $banner->width  = $request->width;
            $banner->height = $request->height;
            $banner->save();
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
