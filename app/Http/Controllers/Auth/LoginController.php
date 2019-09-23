<?php

namespace Lucid\Http\Controllers\Auth;

use Auth;
use Storage;
use Socialite;

use Lucid\User;
use Lucid\user_settings;
use Lucid\Facades\TelexService;
use Lucid\Http\Controllers\Controller;

use Illuminate\Support\Facades\Log;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $user       =   $this->findOrCreateUser($userSocial, $provider);

        if ($user->exists) {
            TelexService::sendEvent('login', $user->toArray(), [ 'name' => $user->name ]);
        } else {
            $user->save();
            TelexService::sendEvent('signup', $user->toArray(), [ 'name' => $user->name ]);
        }

        Auth::login($user, true);
        
        $user_id = $user->id;
        $username = $user->username;
        
        $path = trim($user_id).'/';
        Storage::makeDirectory($user_id);
        Storage::makeDirectory('public/'.$user_id);
        $this->store_settings($path, $user->id);
        $rss = new \Lucid\Core\Document($user_id);
        $rss->DemoRSS();
        return redirect()->to("/{$username}");
}


public function findOrCreateUser($user, $provider){
    $user = User::firstOrNew([ 'provider_id' => $user->id ]);
    
    if ($user->exists) {
        return $user;
    }

    $email = $user->email;
    $username = strstr($email, '@', true);

    $user->fill([
        'name'          => $user->name,
        'email'         => $email,
        'username'      => $username,
        'image'         => $user->avatar,
        'provider_id'   => $user->id,
        'provider'      => $provider,
    ]);

    return $user;
}

public function store_settings($path, $user_id)
{
  $setting       =   user_settings::where('user_id', $user_id)->first();
  if($setting){
      return $setting;
  }
    return  user_settings::create([
        'user_id' => $user_id,
        'user_path' => $path,
        'setting_path' =>"",
    ]);
}

public function logout($username){
    Auth::logout();
    return redirect($username);
}
}
