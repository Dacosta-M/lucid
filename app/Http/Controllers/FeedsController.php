<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Auth;
use DB;
use Lucid\user_settings;
use Lucid\User;
use Lucid\Core\Document;
use Lucid\Core\Follow;
use Lucid\extfeeds;
use Illuminate\Support\Str;


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


            $posts = extfeeds::myFeeds();

    return view('feeds', compact('posts'));

  }else {
          $posts = extfeeds::userFeeds($username);

      return view('feeds', ['posts' => $posts]);
  }
  }

public function ViewManager($username)
{
  if(Auth::user() && Auth::user()->username == $username){

  $user_settings = user_settings::where('user_id', Auth::user()->id)->first();

  return route('home',[$username]);
}
else {
    $user_settings = user_settings::where('user_id', Auth::user()->id)->first();
}
}

  public function homePage(Document $feeds, Follow $follow,Request $request, $username)
  {
    //dd($feeds->getPublishedPosts($username));
    $user = $this->user->where('username',$username)->firstorFail();

    $user_settings = user_settings::where('user_id', $user->id)->first();


    $view = Str::snake($user_settings->view);
    $pview = Str::snake($user_settings->public_view);

    if(Auth::user() && Auth::user()->username == $username){
            $user = Auth::user();
            $username = $user->username;
              $posts = extfeeds::myFeeds();

                    if ($request->ajax()) {
                      return view('feeds', ['user'=>$user,'posts' => $posts])->render();
                  }


//dd($converted);

          return view($view, ['posts' => $posts,'user'=>$user,
          'tabs' => unserialize($user_settings->tabs)
        ]);



      }else {

            //User Follower checker
            if(Auth::user()){
              $fcheck = $follow->followCheck($user->name);
            }
            else {
              $fcheck = "no";
            }
            if($pview  == "home"){
              $userposts = $feeds->getPublishedPosts($username);
              return view('home', ['userposts' => $userposts,
              'user'=>$user,
              'fcheck' => $fcheck]);

            }else {
              $posts = extfeeds::userFeeds($username);

              return view($view, ['posts' => $posts,'user'=>$user,'fcheck' => $fcheck]);


            }


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

  public function Settings(Document $feeds, Follow $follow, $username)
  {
    $user = $this->user->where('username',$username)->firstorFail();
    $following = $follow->subscription($username);
    $user_settings = user_settings::where('user_id', $user->id)->first();


    if(Auth::user()){

      $myfollower = $follow->followerArray();
      $fcheck = $follow->followCheck($user->name);
    }
    else {
      $fcheck = "no";
    }
$rss = DB::table('ext_rsses')->where(['user_id' => Auth::user()->id, 'category' => 'main'])->get();
$users = DB::table('posts')
        ->join('users','posts.user_id','=','users.id')
        ->select('posts.*','users.image','users.username','users.name')
        ->where('tags','!=',NULL)->where('action','publish')->orWhere('action',NULL)->orderBy('id','DESC')->get();

    return view('timeline-setting', ['fcheck' => $fcheck,
    'followerArray' =>$myfollower,
      'following' =>$following,
      'rss' => $rss,
      'users' => $users,
      'user'=>$user,
      'tabs' => unserialize($user_settings->tabs)
    ]);

  }

}
