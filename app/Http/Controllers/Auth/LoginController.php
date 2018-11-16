<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Illuminate\Http\Request;
use Session;

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
        $this->middleware('guest')->except('logout');
    }


    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        dd($user);
        // $user->token;
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallbackGoogle(Request $request)
    {
        // dd($request);
        $user = Socialite::driver('google')->user();
        
        
        $UserData['name'] = $user->name;
        $UserData['email'] = $user->email;
        //$UserData['gender'] = $user->user['gender'];
        $UserData['profile_picture'] = $user->avatar;
        $UserData['status'] = 1;
        $UserData['creation_date'] = date("Y-m-d H:i:s");
        $UserData['updation_date'] = date("Y-m-d H:i:s");
        $UserData['user_type'] = 2;
        $UserData['roles_id'] = null;
        $UserData['social_media_id'] = $user->id;               
        $UserData['subscription_type'] = 0;
        $UserData['forgot_pass'] = 0;
        $status = socialMediaLogin($UserData);
        if($status == true) {
            Session::flash('success', 'You have successfully logged in.'); 
            return redirect(url('home'));
        }              
        // dd($user);
        // $user->token;
    }

}
?>