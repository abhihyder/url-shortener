<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        return view('content.admin.setting.admin_setting');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'keys' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            foreach ($request->keys as $key) {

                $admin_setting = Setting::where('key', $key)->first();
                $value = $request[$key];

                if (is_array($value)) {
                    $value = json_encode($value);
                }

                if ($admin_setting) {
                    $admin_setting->value = $value;
                    $admin_setting->save();
                } else {
                    $admin_setting = new Setting();
                    $admin_setting->key = $key;
                    $admin_setting->value = $value;
                    $admin_setting->save();
                }
            }

            $configs =  Setting::get();
            Cache::put('admin_settings', $configs);
            
            return $this->respondCreated('Admin setting updated successfully!');
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }
}
