<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\ProfileFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $auth = Auth::user();

        return view('content.user.profile', ['profile' => $auth]);
    }

    public function changeInfo(Request $request)
    {
        return ProfileFacade::changeInfo($request->all());
    }

    public function changePass(Request $request)
    {
       return ProfileFacade::changePassword($request->all());
    }

    public function changeTheme(Request $request)
    {
       return ProfileFacade::changeTheme($request->all());
    }
}
