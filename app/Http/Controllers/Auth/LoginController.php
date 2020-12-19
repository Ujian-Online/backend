<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // validate input request
        $request->validate([
            'username'  => 'required|string',
            'password'  => 'required|string|min:3|max:255'
        ]);

        // check if username is email or just username
        $loginType = filter_var(
            $request->username,
            FILTER_VALIDATE_EMAIL
        ) ? 'email' : 'username';

        // set login array
        $login = [
            $loginType  => $request->username,
            'password'  => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect($this->redirectTo);
        } else {
            return redirect()->route('login')->with(['error' => trans('auth.failed')]);
        }
    }
}
