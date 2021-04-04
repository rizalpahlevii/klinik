<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\DashboardRepository;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function login(LoginRequest $request)
    {
        $login = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if (Auth::attempt($login)) {
            $this->sendLoginResponse($request);
        }
        $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $this->redirectTo = '/dashboard';

        if (!isset($request->remember)) {

            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath())
                ->withCookie(\Cookie::forget('username'))
                ->withCookie(\Cookie::forget('password'))
                ->withCookie(\Cookie::forget('remember'));
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath())
            ->withCookie(\Cookie::make('username', $request->username, 3600))
            ->withCookie(\Cookie::make('password', $request->password, 3600))
            ->withCookie(\Cookie::make('remember', 1, 3600));
    }
    public function logout(Request $request)
    {
        $dashboardRepository = new DashboardRepository;
        if ($dashboardRepository->getShift()) {
            $dashboardRepository->endShift();
        }
        Auth::logout();
        return redirect('/');
    }
}
