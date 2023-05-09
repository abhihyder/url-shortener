<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\ProfileInterface;
use App\Rules\MatchOldPassword;
use Hyder\JsonResponse\Facades\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileFacadeService implements ProfileInterface
{
    public function changeInfo(array $request)
    {
        try {
            $profile = Auth::user();

            $validator = $this->validation($request, $profile->id);

            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            $fileContent = $request['file'] ?? null;
            $fileName = null;
            $filePath = null;

            if ($fileContent) {
                $response =  $this->photoUpload($fileContent, $profile);
                $fileName = $response['name'];
                $filePath = $response['path'];
            }

            $profile->name = $request['name'];
            $profile->username = $request['username'];
            $profile->email = $request['email'];
            $profile->file_name = $fileName;
            $profile->file_path  = $filePath;
            $profile->save();
            return JsonResponse::success('Profile updated successfully!');
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    public function changePassword(array $request)
    {
        try {
            $validator = $this->passwordValidation($request);

            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            $profile = Auth::user();
            $profile->password = Hash::make($request['new_password']);
            $profile->save();

            return JsonResponse::success('Password updated successfully!');
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    public function changeTheme(array $request)
    {
        try {
            $validator = Validator::make($request, [
                'theme' => 'required',
            ]);

            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            $profile = Auth::user();
            $profile->is_dark = $request['theme'];
            $profile->save();
            return JsonResponse::success('Theme changed successfully!');
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    private function photoUpload($fileContent, $profile)
    {
        $imgName = $profile->id . date("Ymd_His");
        $ext = strtolower($fileContent->getClientOriginalExtension());
        $fileName = $imgName . '.' . $ext;
        $folder_structure = 'storage/avatars/' . date('Y/m/d');
        $filePath = $folder_structure . '/' . $fileName;
        $fileContent->move($folder_structure, $fileName);
        if ($profile->file_path) {
            if (File::exists($profile->file_path)) {
                File::delete($profile->file_path);
            }
        }

        return ['name' => $fileName, 'path' => $filePath];
    }

    private function validation(array $request, int $id)
    {
        return Validator::make($request, [
            'username' => ['required', 'string', 'alpha_num', 'min:4', 'max:160', Rule::unique('users', 'username')->ignore($id)],
            'email' => ['required', 'string', 'email', 'max:160', Rule::unique('users', 'email')->ignore($id)],
            'file' => (isset($request['file']) && $request['file']) ? 'required|mimes:png,jpg,jpeg|max:1000' : '',
        ]);
    }

    private function passwordValidation(array $request)
    {
        return Validator::make($request, [
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:6|same:confirm_password|different:old_password',
            'confirm_password' => 'required|min:6',
        ]);
    }
}
