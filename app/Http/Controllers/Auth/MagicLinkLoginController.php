<?php

namespace Lucid\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Lucid\Http\Controllers\Controller;
use Lucid\Auth\MagicAuthentication;
use Lucid\UserEmailLoginToken;

class MagicLinkLoginController extends Controller
{
    public function sendToken(Request $request, MagicAuthentication $auth) {
        $this->validate($request,[
            'email'=>'required|email|exists:users,email'
        ]);

        $auth->requestLink();

        return redirect()->to('/login/magic')->with('success','We have sent you a magic link');
    }

    public function validateToken(Request $request, UserEmailLoginToken $token){
        $token->delete();

        Auth::login($token->user, $token->remember);

        return redirect()->to('/'.$token->username);
    }
}
