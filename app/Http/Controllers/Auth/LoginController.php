<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('auth');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attemptWhen(
            $this->credentials($request),
            fn ($user) => $user->status,
            $request->boolean('remember')
        );
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $this->guard()->getLastAttempted();

        throw ValidationException::withMessages([
            $this->username() => [
                $user && $this->guard()->getProvider()->validateCredentials($user, $this->credentials($request))
                    ? 'Your site has been deactivated. Please contact your organization admin for any query'
                    : 'Incorrect ID or Password! Please try again.'
            ]
        ]);
    }

}
