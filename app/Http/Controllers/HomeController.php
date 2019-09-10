<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Validator;
use DB;
use Storage;
use Parsedown;
use Image;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = Auth::user();
      $username = $user['username'];
      $post = new \Lucid\Core\Document($username);
            $feed = $post->fetchRss();
           // print_r($feed);
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

        return view('home', ['fcheck' => $fcheck, 'posts' => $feed,'fcount'=>$fcount, 'count' => $count]);

    }
    public function Old()
{
  $get = DB::table('ext_rsses')->get();
  print_r("total of ". count($get)."</br></br></br>");
foreach ($get as $key => $value) {
  print_r($value->id ."</br>");
}
}
public function new()
{
  $get = DB::table('following')->get();
  print_r("total of ". count($get)."</br></br></br>");
foreach ($get as $key => $value) {
  print_r($value->my_id ."</br>");
}
}
    public function fix()
    {
      $dir = storage_path('app/markessien/');

      return Storage::disk()->files($dir);

    }
    public function timeline($username)
    {
      $user = Auth::user();
      if ($username == $user->username) {

      $username = $user->username;
      $post = new \Lucid\Core\Document($username);

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
        }
        else {
          $fcheck = "no";
        }

     return view('timeline', ['posts' => $post,'fcheck' => $fcheck, 'user'=>$user,'fcount'=>$fcount, 'count' => $count]);
     }else {

        return view($user->username.'/timeline', ['posts' => $post,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);

    }
  }


/*
*
*
*

*/



    public function savePost(Request $request)
    {
      $request->validate([
        'body'=>'required'
      ]);

      $title = '';
      $body = $request->body;
      // filter out non-image data
      $user = Auth::user();
      $username = $user->username;
      $post = new \Lucid\Core\Document($username);
      $result = $post->createThough($body);
      return redirect($username.'/thoughts')->with('msg', 'Post Published');
    }

    public function subscribe()
    {
      $user = Auth::user();
      $username = preg_split('/ +/', $user->name);
      $path = $username[0];

      $post=[];
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

      return view('subscribe', ['fcheck' => $fcheck,'user'=>$user,'fcount'=>$fcount, 'count' => $count]);

    }


    




    

    



    public function updateContactDetails(Request $request){
        $validator=Validator::make($request->all(),[
          'email' => ['required','email',
            Rule::unique('contact_settings')->ignore(Auth::user()->id,'user_id'),
          ],
          'user_id'=>'required'

      ]);

      if($validator->fails()){
        return response()->json($validator->messages(), 200);
      }

      $detailsExist = DB::table('contact_settings')->where('user_id',$request->user_id)->first();

      if(empty($detailsExist)){
        $insert = DB::table('contact_settings')->insert([
          'user_id'=>$request->user_id,
          'email'=>$request->email,
          'display_message'=>$request->message
        ]);

        if($insert) {
          return response()->json(['success'=>'Your changes has been saved successfully'], 200);
        }


      }else{
        $update = DB::table('contact_settings')->where('user_id',$request->user_id)->update([
          'email'=>$request->email,
          'display_message'=>$request->message
        ]);

        if($update) {
          return response()->json(['success'=>'Your changes has been saved successfully'], 200);
        }else{
          return response()->json(['noChanges'=>'You made no changes'], 200);
        }
      }

    }

    

    // debuging tools
public function checkpost($value)
{
   $post = DB::table('posts')->where('id',$value)->first();
 echo "title: ".$post->title."</br>" ;
 echo "id: ".$post->id."</br>";
 echo "user_id: ".$post->user_id."</br>";
 echo "content: ".$post->content."</br>";
 echo "slug: ".$post->slug."</br>";
//print_r( $post);
echo "feed</br></br></br></br>";
$post = DB::table('extfeeds')->where('title',$post->title)->first();
echo "post:title ".$post->title."</br>";
echo "post:slug ".$post->link."</br>";

$title = "this is live.com live?";
//$slug = str_replace(' ', '-', $title);


echo Str::slug($title);
}
public function dropfeed()
{

  $c = \Lucid\extfeeds::getQuery()->delete();
  print_r($c);
}
public function loadfeed($user)
{

$post = new \Lucid\Core\Document($user);
$post = $post->fetchAllRss();
//dd($post );

print_r($post);
}

public function postFixer()
{
  $oldpost = DB::table('posts')->get();
  foreach ($oldpost as $key => $value) {
  //  dd($value->title);
    $slug = Str::slug($value->title);
    $slug = $slug ."-".substr(md5(uniqid(mt_rand(), true)), 0, 3);

    $updateFeeds = DB::table('posts')->where(['title'=>$value->title, 'user_id' => $value->user_id])
    ->update([
      'slug'=> $slug
    ]);
  }
//  dd($oldpost->title);

print_r($updateFeeds);
}

//end of debuging tools
    public function saveComment(Request $request, $username) {

          $user_id = Auth::user()->id;
         $validator=Validator::make($request->all(),[
           'body' =>'required',
           'post_id'=>'required'
        ]);

       if($validator->fails()){
         return response()->json($validator->messages(), 200);
     }


        if (isset($request->parents_id) && $request->parents_id !== "") {
          // code...
          $parentPost = $request->parents_id;
        }else {
          $parentPost = null;
        }
        if (isset($request->user_id) && $request->user_id !== "") {
          // code...
          $puser_id= $request->user_id;
        }else {
          $post = DB::table('posts')->where('id', $request->post_id)->first();
          $puser_id = $post->user_id;
        }
    //     dd($post);
      $createComment = DB::table('notifications')->insert([
        'post_id'=>$request->post_id,
        'parent_comment_id'=>$parentPost,
        'comment'=>$request->body,
        'sender_id'=> $user_id,
        'user_id'=>$puser_id,
        'status'=> 0,
        'action'=>$request->action,
        'type'=>"Post",
      ]);
 //dd($createComment);

      if($createComment){
        return response()->json(['comment'=>'saved'], 200);
      }else{
        return response()->json(['error'=>'Sorry an error occured while processing your comment.']);
      }

    }


    

    

}
