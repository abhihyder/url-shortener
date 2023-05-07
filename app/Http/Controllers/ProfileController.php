<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $auth = Auth::user();

        return view('content.user.profile', ['profile' => $auth]);
    }

    public function changeInfo(Request $request)
    {
        try {
            $profile = Auth::user();
            $validation_rule = [
                'username' => ['required', 'string', 'alpha_num', 'min:4', 'max:160', Rule::unique('users', 'username')->ignore($profile->id)],
                'email' => ['required', 'string', 'email', 'max:160', Rule::unique('users', 'email')->ignore($profile->id)],
            ];

            if ($request->file('file')) {
                $validation_rule['file'] = 'required|mimes:png,jpg,jpeg|max:500';
            }

            $validator = Validator::make($request->all(), $validation_rule);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }


            $fileContent = $request->file('file');
            $fileName = null;
            $filePath = null;
            $folder_structure = null;

            if ($fileContent) {
                $imgName = $profile->id . date("Ymd_His");
                $ext = strtolower($fileContent->getClientOriginalExtension());
                $fileName = $imgName . '.' . $ext;
                $folder_structure = 'storage/avatars/' . date('Y/m/d');
                $filePath = $folder_structure . '/' . $fileName;
                $fileContent->move($folder_structure, $fileName);
                if ($profile->file_path) {
                    if (FacadesFile::exists($profile->file_path)) {
                        FacadesFile::delete($profile->file_path);
                    }
                }
            }

            DB::beginTransaction();
            $profile->name = $request->name;
            $profile->username = $request->username;
            $profile->email = $request->email;
            $profile->file_name = $fileName;
            $profile->file_path  = $filePath;
            $profile->save();
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    public function changePass(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => ['required', new MatchOldPassword],
                'new_password' => 'required|min:6|same:confirm_password|different:old_password',
                'confirm_password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            DB::beginTransaction();
            $profile = Auth::user();
            $profile->password = Hash::make($request->new_password);
            $profile->save();
            DB::commit();

            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }
    public function changeTheme(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'theme' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }

            DB::beginTransaction();
            $profile = Auth::user();
            $profile->is_dark = $request->theme;
            $profile->save();
            DB::commit();

            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }
}
