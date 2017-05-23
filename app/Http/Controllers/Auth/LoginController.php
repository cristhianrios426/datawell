<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\ORM\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $credentials['state'] = User::ACTIVE;
        return $this->guard()->attempt(
            $credentials, $request->has('remember')
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [ 'messages'=>['messages'=>[trans('auth.failed')], 'type'=>'danger' ] ];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }
    protected function redirectTo(){
        return route('well.index');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        if ($request->expectsJson()) {
            return response()->json(['messages'=>[ 'messages'=>[trans('auth.welcome')] , 'type'=>'success' ] , 'redirect'=>$this->redirectTo(), 'delay'=>2000 ]);
        }
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }
}
