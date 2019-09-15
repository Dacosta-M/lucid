<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Lucid\User;
use Lucid\Core\Document;
use Lucid\Core\FOllow;


class FeedsController extends Controller
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


  public function Feeds(Document $feeds, $username)
  {

    $user = $this->user->where('username',$username)->firstorFail();

    if(Auth::user() && Auth::user()->username == $username){
            $user = Auth::user();
            $username = $user->username;
            $feeds = $feeds->MyFeeds($username);
          //  dd($feeds);

    return view('feeds', ['posts' => $feeds]);

    }else {

        $feeds = $feeds->Feeds($username);

      return view('feeds', ['posts' => $feeds]);
  }
  }

  public function homePage(Document $feeds, Follow $follow, $username)
  {

    //dd($feeds->getPublishedPosts($username));
    $user = $this->user->where('username',$username)->firstorFail();

    if(Auth::user() && Auth::user()->username == $username){
            $user = Auth::user();
            $username = $user->username;
            $feeds = $feeds->MyFeeds();

            return view('timeline', ['user'=>$user]);

      }else {

            //User Follower checker
            if(Auth::user()){
              $fcheck = $follow->followCheck($user->name);
            }
            else {
              $fcheck = "no";
            }

             $userposts = $feeds->getPublishedPosts($username);
            return view('home', ['userposts' => $userposts,
            'user'=>$user,
            'fcheck' => $fcheck]);

      }


  }
  public function posts(Document $feeds, Follow $follow,$username){


    $user = $this->user->where('username',$username)->firstorFail();

              if(Auth::user() && $username == Auth::user()->username){
                $user = $this->user->where('username',$username)->firstorFail();

                $posts=$feeds->fetchAllRss($username);



                //User Follower checker
                if(Auth::user()){
                  $fcheck = $follow->followCheck($user->name);
                }
                else {
                  $fcheck = "no";
                }

                //  dd(  $like );
                return view('post',compact('user','posts'), ['fcheck' => $fcheck,
              ]);
            }else {
              return redirect('/'.$username);
            }

  }


  public function thoughts(Document $feeds, Follow $follow,$username)
  {
    $user = $this->user->where('username',$username)->firstorFail();


    $post = $feeds->Thoughts($username);
    // follower and following Count

    if(Auth::user()){
      $fcheck = $follow->followCheck($user->name);
    }
    else {
      $fcheck = "no";
    }

    return view('thoughts', ['fcheck' => $fcheck,'posts' => $post,'user'=>$user]);

  }


}
