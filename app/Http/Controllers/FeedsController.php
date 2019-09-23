<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Lucid\User;
use Lucid\Core\Document;
use Lucid\Core\Follow;


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


  public function thoughts(Document $feeds, Follow $follow,$username)
  {
    $user = $this->user->where('username',$username)->firstorFail();


    $posts = $feeds->Thoughts($username);
    // follower and following Count

    if(Auth::user()){
      $fcheck = $follow->followCheck($user->name);
    }
    else {
      $fcheck = "no";
    }
    $hashTag = "#";
    $postArr=[];
    foreach($posts as $post ) {
      $stringArr  = explode(" ", $post['body']);
      for($i=0; $i<count($stringArr);$i++) {
        if(substr($stringArr[$i],0,1)===$hashTag) {
          $text = $stringArr[$i];
          $text = preg_replace('#[^0-9a-z]#i','',$text);
          $stringArr[$i] = '<a href="#" class="text-main text-alt">'.$stringArr[$i].'</a>';
        }
      }
      $post['body'] = implode(' ', $stringArr);
      $postArr[] = $post;
    }

    return view('thoughts', ['fcheck' => $fcheck,'posts' => $postArr,'user'=>$user]);

  }


}
