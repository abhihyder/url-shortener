<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use App\Utilities\SendMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $ref= $request->ref;
        return view('auth.register', ['ref'=>$ref]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validation_rule = [
            'username' => ['required', 'string', 'alpha_num', 'min:4', 'max:160', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:160', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed', Rules\Password::defaults()],
        ];
        
        if ($request->referrer) {
            $validation_rule['referrer'] = ['required', 'string', 'alpha_num', 'min:4', 'max:160', 'exists:users,username'];
        }

        $request->validate($validation_rule);

        $referrer_id = null;

        if ($request->referrer) {
            $referrer = User::where('username', $request->referrer)->first();
            if ($referrer) {
                $referrer_id = $referrer->id;
            }
        }

        $ip = getIP();
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referrer_id' => $referrer_id,
            'login_ip' => $ip,
            'register_ip' => $ip,
        ]);

        // Send mail-----------------
        SendMail::welcomeMail($user);

        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->save();
        // event(new Registered($user));

        Auth::login($user);
        $auth = Auth::user();

        if ($auth->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('file.index');
    }
}
