<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Parsedown;
use URL;
use Str;
use Lucid\Notification;
use Carbon\Carbon;
use Image;
class PostController extends Controller
{
    public function user($username) {
        $user_exists = DB::table('users')->where('name',$username)->orWhere('username',$username)->get();
      
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

                $post = $post->MyFeeds();
              
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


  
                $tabs = DB::table('interests')->get();
                return view('timeline', [
                  'fcheck' => $fcheck,
                  'user'=>$user,
                  'fcount'=>$fcount,
                  'count' => $count]);

        }else {


            $app = new \Lucid\Core\Document($username);
            $feed =$app->Feeds();
          
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

               $userposts=$app->getPublishedPosts($username);

              return view('home', ['userposts' => $userposts,'user'=>$user,'fcheck' => $fcheck,'fcount'=>$fcount, 'count' => $count]);

        }

    }

    public function posts($username){

        if(Auth::user() && $username == Auth::user()->username){

        if(!$this->user($username)) {
            return abort(404);
        }

        $user = $this->user($username);
        $app  = new \Lucid\Core\Document($username);
        $posts=$app->fetchAllRss();

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
          $post_id = isset($post_id) ? $post_id:'';
          $likes = DB::table('notifications')
                  ->where('post_id',$post_id)
                  ->where('notifications.action','=',"like")
                  ->get();
                //  dd(  $like );
        return view('post',compact('user','posts'), [
          'fcheck' => $fcheck,
          'fcount'=>$fcount,
          'count' => $count,
          'likes' => $likes
        ]);
    }else {
        return redirect('/'.$username);
    }

  }

  public function singlePostPage($username,$postSlug){
    // return $postSlug;
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

  public function getPostData($username,$postSlug) {
    $app = new \Lucid\Core\Document($username);
    $post=$app->getPost($username,$postSlug);
    if(!$post){
        return response()->json(['error'=>'post not found'],404);
    }
    return response()->json(['data'=>$post]);
  }

  public function publish(Request $request,$username) {
      $title = isset($request->title) ? $request->title : '';
      $content = $request->postVal;
      $tags = $request->tags;
      $action = $request->action;


        $initial_images = array_filter($request->all(), function ($key) {
          return preg_match('/^img-\w*$/', $key);
      }, ARRAY_FILTER_USE_KEY);

      $images = [];
      foreach ($initial_images as $key => $value) {
          $newKey = preg_replace('/_/', '.', $key);
          $images[$newKey] = $value;
          // Log::debug($value);

      }
      $post = new \Lucid\Core\Document($username);
      $createPostAction = $post->createPost($title, $content, $tags, $images,$username,$action);

    //  dd(  $createPost);
      if($createPostAction == "publish" ){
        return response()->json(["error" => false, "action"=>"publish", "message" => "Post published successfully"],200);
      }else if ($createPostAction == "draft") {
        return response()->json(["error" => false, "action"=>"draft", "message" => "Post published successfully"],200);
      }else if($createPostAction == false){
        return response()->json(["error" => true, "action"=>"publish", "message" => "Failed while processing your request, please try again"]);
      }
  }

  public function editPost(Request $request, $username) {

      $title = isset($request->title) ? $request->title : '';
      $content = $request->postVal;
      $tags = $request->tags;
      $post_id = $request->post_id;
      $action = $request->action;


        $initial_images = array_filter($request->all(), function ($key) {
          return preg_match('/^img-\w*$/', $key);
      }, ARRAY_FILTER_USE_KEY);

      $images = [];
      foreach ($initial_images as $key => $value) {
          $newKey = preg_replace('/_/', '.', $key);
          $images[$newKey] = $value;
      }
      $post = new \Lucid\Core\Document($username);
      $updatePost = $post->saveUpdatedPost($title, $content, $tags, $images,$username,$post_id,$action);

      if($updatePost){
        return response()->json(["error" => false, "action"=>"update", "message" => "Post Updated successfully"],200);
      }else{
        return response()->json(["error" => true, "action"=>"error", "message" => "Fail while publishing, please try again"]);
      }
  }

  public function deletePost(Request $request, $username){
    $post = DB::table('posts')->where('id',$request->post_id)->first();
    $parsedown  = new Parsedown();
    $postContent = $parsedown->text($post->content);
    preg_match_all('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $postContent, $matches);
    foreach($matches[1] as $found_img) {
      $image_name_array = explode('/',$found_img);
      $img_name = end($image_name_array);
      $imagePath = storage_path('app/public/'.$post->user_id.'/images/'.$img_name);
      if(file_exists($imagePath)) {
        unlink($imagePath);
      }
    }
    DB::table('notifications')->where('post_id',$post->id)->delete();
     DB::table('extfeeds')->where('title',$post->title)->delete();
   $deletePost = DB::table('posts')->where('id',$post->id)->delete();
   if($deletePost) {
     return response()->json(['success'=>"Post Successfully Deleted"],200);
   }else{
     return response()->json(['error'=>"Something not right"],500);
   }

 }

 public function updatePostStatus($username,$post_id,$action){
  $update = DB::table('posts')->where('id',$post_id)->update([
    'action'=>$action,
  ]);

  if($update) {
    return response()->json(['success'=>true],200);
  }else{
    return response()->json(['success'=>false],200);
  }
}

}
