<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Lucid\User;
use Lucid\Core\Follow;

class FollowController extends Controller
{

/**
    * The user repository implementation.
    *
    * @var User
    */
   protected $users;

   /**
    * Create a new controller instance.
    *
    * @param  User  $users
    * @return void
    */
   public function __construct(User $user)
   {
       $this->user = $user;
   }


  public function following(Follow $follow, $username) {

    $user = $this->user->where('username',$username)->firstorFail();

            $following = $follow->subscription($username);
            $follower = $follow->subscriber($username);


    //User Follower checker
              if(Auth::user()){
                    $fcheck = $follow->followCheck($user->name);
                  $myfollower = $follow->followerArray();
              //    dd($myfollower);
              }
              else {
                $fcheck = "no";
                $myfollower = [];
              }

    return view('follow-details', [
      'fcheck' => $fcheck,
      'user'=>$user,
      'following' => $following,
      'follower' => $follower,
      'followerArray' =>$myfollower
    ]);
  }

  public function followers(Follow $follow, $username) {

    $user = $this->user->where('username',$username)->firstorFail();

            $following = $follow->subscription($username);
            $follower = $follow->subscriber($username);
    //User Follower checker
                if(Auth::user()){
                  $fcheck = $check->followCheck($user->name);
                  $myfollower = $check->followerArray();
  //dd($myfollower);
                }
                else {
                  $fcheck = "no";
                  $myfollower = [];
                }

    return view('follow-details', [
      'fcheck' => $fcheck,
      'user'=>$user,
      'following' => $following,
      'follower' => $follower,
      'followerArray' =>$myfollower
    ]);
  }


}
