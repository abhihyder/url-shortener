<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if ($request->has('remember')) {
            $request->merge(['remember' => true]);
        }
        $request->merge(['status' => true]);
        $login_by =  $request->input('email');

        $fieldType = filter_var($login_by, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->merge([$fieldType => $login_by]);

        $request->authenticate($fieldType);

        $request->session()->regenerate();

        $auth = Auth::user();

        if ($auth->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
