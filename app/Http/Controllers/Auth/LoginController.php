<?php

namespace App\Http\Controllers\Auth;

use App\Leqaa\UserManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout','redirectToProvider','handleProviderCallback');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request, $provider)
    {
        if(! in_array($provider, UserManager::getProviders()))
            return redirect()->to($this->redirectTo);

        $driver = Socialite::driver($provider);

        if($provider === 'github')
            $driver->scopes(['read:user']);

        return $driver->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        if(! in_array($provider, UserManager::getProviders()))
            return redirect()->to($this->redirectTo);

        $user = Socialite::driver($provider)->user();

        UserManager::loginSocialUser($user, $provider);

        return redirect()->to($this->redirectTo);
    }
}
