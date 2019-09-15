<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use Parsedown;
use Image;
use Lucid\User;
use Lucid\Core\Document;
use Lucid\Core\FOllow;
use Illuminate\Support\Facades\Log;
class PostController extends Controller
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



    public function user($username) {
        $user_exists = DB::table('users')->where('name',$username)->orWhere('username',$username)->get();

        if(!isset($user_exists[0])) {
            return false;
        }
        return $user_exists[0];
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



          public function singlePostPage(Document $post, Follow $follow, $username,$postSlug){
            // return $postSlug;
            $user = $this->user->where('username',$username)->firstorFail();


              $post=$post->getPost($username,$postSlug);

              if(!$post){
                  return redirect('/'.$username);
              }

              //User Follower checker
              if(Auth::user()){
                $fcheck = $follow->followCheck($user->name);
              }
              else {
                $fcheck = "no";
              }


              return view('single-blog-post',compact('post','user'),['fcheck' => $fcheck, ]);
          }




  public function getPostData(Document $post, Follow $follow, $username,$postSlug) {

    $post=$post->getPost($username,$postSlug);
    if(!$post){
        return response()->json(['error'=>'post not found'],404);
    }
    return response()->json(['data'=>$post]);
  }



  public function publish(Request $request,Document $post,$username) {
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

  public function editPost(Request $request,Document $post, $username) {

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
