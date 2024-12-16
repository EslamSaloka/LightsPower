<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Auth\AuthRequest;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = "dashboard";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if(request()->is('*dashboard*')) {
            return view('admin.pages.auth.login');
        }
    }

        /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(AuthRequest $request)
    {

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if($this->guard()->user()->suspend == 1) {
                $this->guard()->logout();
                return redirect()->route('admin.login')->withErrors([
                    'object' => __('تم إيقاف الحساب الشخصي الخاص بكم من قبل الإداره')
                ])->withInput();
            }

            if(in_array(\App\Models\User::TYPE_CUSTOMER,$this->guard()->user()->roles()->pluck("name")->toArray())) {
                $this->guard()->logout();
                return redirect()->route('admin.login')->withErrors([
                    'object' => __('غير مسموح لك بالدخول')
                ])->withInput();
            }

            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function username()
    {
        return 'object';
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $data["password"] = $request->password;
        if(is_numeric($request->object)) {
            $data["phone"] = $request->object;
        } else if(filter_var($request->object, FILTER_VALIDATE_EMAIL)) {
            $data["email"] = $request->object;
        } else {
            $data["username"] = $request->object;
        }
        if( $this->guard()->attempt($data, $request->boolean('remember'))) {
            return true;
        }
        return false;
    }
}
