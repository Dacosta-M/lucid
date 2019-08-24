<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Parsedown;
use URL;
use Carbon\Carbon;
class pageController extends Controller
{
    public function user($username) {
        $user_exists = DB::table('users')->where('name',$username)->orWhere('username',$username)->get();
      //  dd($user_exists);
        if(!isset($user_exists[0])) {
            return false;
        }
        return $user_exists[0];
    }

    public function homePage($username)
    {
        if(!$this->user($username)) {
            return abort(404);
        }
        $user = $this->user($username);
        if(Auth::user() && Auth::user()->username == $username){
                $user = Auth::user();
                $username = $user->username;

                $post = new \Lucid\Core\Document($username);
                $following = $post->subscription();
                $follower = $post->subscriber();
                $post = $post->Feeds();
            //$post =[];
                $sub = new \Lucid\Core\Subscribe($username);
                $fcount = $sub->myfollowercount();
                if (!empty($fcount)) {
                    $fcount = count($fcount);
                  }else {
                    $fcount = "";
                  }
                $fcheck = $sub->followCheck($user->name);

                $count = $sub->count();
                if (!empty($count)) {
                  $count = count($count);
                }
                else {
                  $count = "";
                }


  //dd($fcheck);
                return view('timeline', ['posts' => $post,'fcheck' => $fcheck,'user'=>$user,'fcount'=>$fcount, 'count' => $count, 'following' => $following, 'follower' => $follower]);

        }else {


            $app = new \Lucid\Core\Document($username);
            $feed =$app->Feeds();
          //  dd(  $feed);
            // follower and following Count
            $sub = new \Lucid\Core\Subscribe($username);
            $fcount =$sub->myfollowercount();
            $count = $sub->count();
            //dd($fcount);
            if (!empty($fcount)) {
                $fcount = count($fcount);
              }else {
                $fcount = "";
              }
              if (!empty($count)) {
                $count = count($count);
              }else {
                $count = "";
              }


              //User Follower checker
              if(Auth::user()){
                $check = new \Lucid\Core\Subscribe(Auth::user()->username);
                $fcheck = $check->followCheck($user->name);
              }
              else {
                $fcheck = "no";
              }
            //  $follower = $app->subscription();
               //dd($follower);

               $userposts=$app->getPosts($username);

              return view('home', ['userposts' => $userposts,'user'=>$user,'fcheck' => $fcheck,'fcount'=>$fcount, 'count' => $count]);

        }


    }


    public function singlePostPage($username,$postSlug){
        if(!$this->user($username)) {
            return abort(404);
        }
        $user = $this->user($username);
        $app  = new \Lucid\Core\Document($username);
      //  $id = base64_decode($id);

        $post=$app->getPost($username,$postSlug);

        if(!$post){
            return redirect('/'.$username.'/home');
        }

        // follower and following Count
        $sub = new \Lucid\Core\Subscribe($username);
        $fcount =$sub->myfollowercount();
        $count = $sub->count();
        //dd($fcount);
        if (!empty($fcount)) {
            $fcount = count($fcount);
          }else {
            $fcount = "";
          }
          if (!empty($count)) {
            $count = count($count);
          }else {
            $count = "";
          }


          //User Follower checker
          if(Auth::user()){
            $check = new \Lucid\Core\Subscribe(Auth::user()->username);
            $fcheck = $check->followCheck($user->name);
          }
          else {
            $fcheck = "no";
          }

        return view('single-blog-post',compact('post','user'),['fcheck' => $fcheck, 'fcount'=>$fcount, 'count' => $count ]);
    }



    public function clean($string) {
      $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

      return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function trim_words($string,$limit,$break=".",$pad="...")
    {
        if (strlen($string) <= $limit) return $string;

        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }

        return $string;
    }

    public function posts($username){

            if(Auth::user() && $username == Auth::user()->username){

            if(!$this->user($username)) {
                return abort(404);
            }

            $user = $this->user($username);
            $app  = new \Lucid\Core\Document($username);
            $posts=$app->getPosts();

            //dd($posts);
            // follower and following Count
            $sub = new \Lucid\Core\Subscribe($username);
            $fcount =$sub->myfollowercount();
            $count = $sub->count();
            //dd($fcount);
            if (!empty($fcount)) {
                $fcount = count($fcount);
              }else {
                $fcount = "";
              }
              if (!empty($count)) {
                $count = count($count);
              }else {
                $count = "";
              }


              //User Follower checker
              if(Auth::user()){
                $check = new \Lucid\Core\Subscribe(Auth::user()->username);
                $fcheck = $check->followCheck($user->name);
              }
              else {
                $fcheck = "no";
              }

            return view('post',compact('user','posts'), ['fcheck' => $fcheck, 'fcount'=>$fcount, 'count' => $count ]);
        }else {
            return redirect('/'.$username);
        }

    }

    public function contact($username){
        if(!$this->user($username)) {
            return abort(404);
        }

        $user = $this->user($username);
        // follower and following Count
        $sub = new \Lucid\Core\Subscribe($username);
        $fcount =$sub->myfollowercount();
        $count = $sub->count();
        //dd($fcount);
        if (!empty($fcount)) {
            $fcount = count($fcount);
          }else {
            $fcount = "";
          }
          if (!empty($count)) {
            $count = count($count);
          }else {
            $count = "";
          }


          //User Follower checker
          if(Auth::user()){
            $check = new \Lucid\Core\Subscribe(Auth::user()->username);
            $fcheck = $check->followCheck($user->name);
          }
          else {
            $fcheck = "no";
          }



        $contact = DB::table('contact_settings')->where('user_id',$user->id)->first();


        return view('contact',compact('user','posts','contact'), ['fcheck' => $fcheck, 'fcount'=>$fcount, 'count' => $count ]);
    }



    public function thoughts($username)
    {
      if(!$this->user($username)) {
          return abort(404);
      }

      $user = $this->user($username);
      $post = new \Lucid\Core\Document($username);
      $post = $post->Thoughts();
      // follower and following Count
      $sub = new \Lucid\Core\Subscribe($username);
      $fcount =$sub->myfollowercount();
      $count = $sub->count();
      //dd($fcount);
      if (!empty($fcount)) {
          $fcount = count($fcount);
        }else {
          $fcount = "";
        }
        if (!empty($count)) {
          $count = count($count);
        }else {
          $count = "";
        }


        //User Follower checker
        if(Auth::user()){
          $check = new \Lucid\Core\Subscribe(Auth::user()->username);
          $fcheck = $check->followCheck($user->name);
        }
        else {
          $fcheck = "no";
        }

      return view('thoughts', ['fcheck' => $fcheck,'posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);

    }

    public function following($username) {
        if(!$this->user($username)) {
          return abort(404);
      }
      $user = $this->user($username);

      $post = new \Lucid\Core\Document($username);
              $following = $post->subscription();
              $follower = $post->subscriber();
              $post = $post->fetchAllRss();
              // follower and following Count
              $sub = new \Lucid\Core\Subscribe($username);
              $fcount =$sub->myfollowercount();
              $count = $sub->count();
              //dd($fcount);
              if (!empty($fcount)) {
                  $fcount = count($fcount);
                }else {
                  $fcount = "";
                }
                if (!empty($count)) {
                  $count = count($count);
                }else {
                  $count = "";
                }


                //User Follower checker
                if(Auth::user()){
                  $check = new \Lucid\Core\Subscribe(Auth::user()->username);
                  $fcheck = $check->followCheck($user->name);
                    $myfollower = $check->followerArray();
                //    dd($myfollower);
                }
                else {
                  $fcheck = "no";
                  $myfollower = [];
                }

      return view('follow-details', [
        'fcheck' => $fcheck,
        'posts' => $post,
        'user'=>$user,
        'fcount'=>$fcount,
        'count' => $count,
        'following' => $following,
        'follower' => $follower,
        'followerArray' =>$myfollower
      ]);
    }

    public function followers($username) {
        if(!$this->user($username)) {
          return abort(404);
      }
      $user = $this->user($username);

      $post = new \Lucid\Core\Document($username);
                $following = $post->subscription();
                $follower = $post->subscriber();
                $post = $post->fetchAllRss();
                // follower and following Count
                $sub = new \Lucid\Core\Subscribe($username);
                $fcount =$sub->myfollowercount();
                $count = $sub->count();
                //dd($fcount);
                if (!empty($fcount)) {
                    $fcount = count($fcount);
                  }else {
                    $fcount = "";
                  }
                  if (!empty($count)) {
                    $count = count($count);
                  }else {
                    $count = "";
                  }
//dd($following);

                  //User Follower checker
                  if(Auth::user()){
                    $check = new \Lucid\Core\Subscribe(Auth::user()->username);
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
        'posts' => $post,
        'user'=>$user,
        'fcount'=>$fcount,
        'count' => $count,
        'following' => $following,
        'follower' => $follower,
        'followerArray' =>$myfollower
      ]);
    }


    public function construction(){
      return view('under-construction');
    }

    public function saveSubscriptionEmail(Request $request){
        $validator=Validator::make($request->all(),[
          'email' =>'required|email'
      ]);

      if($validator->fails()){
        return response()->json($validator->messages(), 200);
    }

    $insert = DB::table('maillists')->insert([
      'email'=>$request->email
    ]);

    if($insert){
      return response()->json(['success'=>'Thanks For Subscribing To Our Newsletters'], 200);
    }


  }


  public function comments($username, $post_id) {

    $comments = DB::table('notifications')
                ->join('users','notifications.sender_id','=','users.id')
                ->select('notifications.*','users.username','users.email','users.image')
                ->where('notifications.post_id',$post_id)
                ->orderBy('notifications.id','DESC')
                ->get();
    $carbon =  new Carbon;
    return view('comments')->with(['comments'=>$comments,'carbon'=>$carbon]);

  }
  public function notification(Request $request, $username)
  {

    if($request->view != '')

    {
      DB::table('notifications')
            ->where(['post_user_id' => Auth::user()->id, 'status' => 0 ] )
            ->update(['status' => 1]);

    }

    $user =   DB::table('users')->where('username', $username)->first();

    $notif = DB::table('notifications')
                ->join('users','notifications.post_user_id','=','users.id')
                ->join('posts','notifications.post_id','=','posts.id')
                ->select('notifications.*', 'posts.title', 'posts.slug', 'users.username','users.email','users.image')
                ->where(['notifications.post_user_id' => Auth::user()->id] )
                ->where('notifications.sender_id', "!=", Auth::user()->id)
                ->orderBy('notifications.id','DESC')
                ->get();

  $output = '';
  if (count($notif ) > 0) {

  foreach ($notif as $notifs) {

    if ($notifs->action == 'Commented') {
            $output .='
            <div class="post-content border p-3">
              <img src="'.$notifs->image.'" class="img-fluid img-thumb" alt="user" />
              <div class="post-content-body">
                <a class="m-0 font-weight-bold" href="'.URL::to('/').'/'.$notifs->username.'">'.$notifs->username.'</a> commented on your post <a href="'.URL::to('/').'/'.$notifs->username.'/post/'.$notifs->slug.'" class="font-weight-bold">'.$notifs->title.'</a>
              </div>
            </div>';

    }
    }
  }else{
        $output .= '
        <div class="post-content border p-3"><div class="post-content-body">
            <p> No Notification Found</p>
          </div>
        </div>';
    }

    $notif = DB::table('notifications')
                ->where(['post_user_id' => Auth::user()->id, 'status' => 0 ] )
                ->where('sender_id', "!=", Auth::user()->id)
                ->get();

    $count = count($notif);

    //dd($count);
    $data = array(
       'notification' => $output,
       'unseen_notification'  => $count
    );
    return response()->json($data);

    }



}
