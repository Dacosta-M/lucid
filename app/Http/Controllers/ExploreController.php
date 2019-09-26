<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Str;
use Validator;
use Parsedown;
use URL;
use Str;
use Lucid\Notification;
use Carbon\Carbon;


class ExploreController extends Controller
{
    public function explorePage(){
        $interests = DB::table('interests')->get();
    
        return view('explore')->with('interests',$interests);
    }

    public function postCategories($category) {
        $categories = explode(',',$category);
        $posts = DB::table('posts')
                 ->join('users','posts.user_id','=','users.id')
                 ->select('posts.*','users.image','users.username')
    
                 ->where('tags','!=',NULL)->where('action','publish')->orWhere('action',NULL)->orderBy('id','DESC')->get();
    
        $users = DB::table('posts')
                ->join('users','posts.user_id','=','users.id')
                ->select('posts.*','users.image','users.username')
                ->where('tags','!=',NULL)->where('action','publish')->orWhere('action',NULL)->orderBy('id','DESC')->get();
    
        return view('category')->with(['categories'=>array_reverse($categories),'posts'=>$posts,'pageController'=>new pageController,'users'=>$users]);
    }

    public function filterPost($method) {

        if($method == "Recent"){
    
          $posts = DB::table('posts')
                    ->join('users','posts.user_id','=','users.id')
                    ->select('posts.*','users.image','users.username')
                    ->orderBy('posts.id','DESC')
                    ->get();
          if(!empty($posts)){
    
            $allPost = [];
          foreach($posts as $post){
            $parsedown  = new Parsedown();
            $postContent = $parsedown->text($post->content);
            preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $postContent, $matches);
            $first_img = "";
            if (isset($matches[1])) {
                // there are images
                $first_img = $matches[1];
                // strip all images from the text
                $postContent = preg_replace("/<img[^>]+\>/i", " ", $postContent);
            }
            $createdAt = Carbon::parse($post->created_at);
            $content['title'] = $post->title;
            $content['body']  = $this->trim_words($postContent, 500);
            $content['tags']  = $post->tags;
            $content['slug']  = $this->clean($post->slug);
            $content['image'] = $first_img;
            $content['date']  =  $createdAt->format('M jS, Y h:i A');;
            $content['id'] = $post->id;
            $content['username'] = $post->username;
            $content['user_img'] = $post->image;
    
            array_push($allPost,$content);
          }
          return view('filtered-posts')->with(['posts'=>$allPost]);
    
          }
    
        }elseif($method =="Popular"){
    
          $posts = DB::table('posts')
                    ->join('users','posts.user_id','=','users.id')
                    ->join('notifications','posts.id','=','notifications.post_id')
                    ->select('posts.*','users.image','users.username',DB::raw('count(notifications.comment) as total'))
                    ->groupBy('posts.id')
                    ->orderBy('total', 'DESC')
                    ->get();
            if(!empty($posts)){
    
              $allPost = [];
            foreach($posts as $post){
              $parsedown  = new Parsedown();
              $postContent = $parsedown->text($post->content);
              preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $postContent, $matches);
              $first_img = "";
              if (isset($matches[1])) {
                  // there are images
                  $first_img = $matches[1];
                  // strip all images from the text
                  $postContent = preg_replace("/<img[^>]+\>/i", " ", $postContent);
              }
              $createdAt = Carbon::parse($post->created_at);
              $content['title'] = $post->title;
              $content['body']  = $this->trim_words($postContent, 500);
              $content['tags']  = $post->tags;
              $content['slug']  = $this->clean($post->slug);
              $content['image'] = $first_img;
              $content['date']  =  $createdAt->format('M jS, Y h:i A');;
              $content['id'] = $post->id;
              $content['username'] = $post->username;
              $content['user_img'] = $post->image;
    
              array_push($allPost,$content);
            }
            return view('filtered-posts')->with(['posts'=>$allPost]);
    
            }
        }
      }
    
    
      
    
      public function interest($interest){
        $posts = DB::table('posts')
                 ->join('users','posts.user_id','=','users.id')
                 ->select('posts.*','users.image','users.username')
                 ->where('tags','!=',NULL)->orderBy('id','DESC')->get();
        $interestsArray = [];
        $interestPosts=[];
        foreach($posts as $post) {
           $tags = explode(',',$post->tags);
           $tags = array_filter(array_map('trim',$tags));
           $tags = array_filter(array_map('strtolower',$tags));
           if(in_array(strtolower($interest), $tags)) {
    
              $parsedown  = new Parsedown();
              $postContent = $parsedown->text($post->content);
              preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $postContent, $matches);
              $first_img = "";
              if (isset($matches[1])) {
                  // there are images
                  $first_img = $matches[1];
                  // strip all images from the text
                  $postContent = preg_replace("/<img[^>]+\>/i", " ", $postContent);
              }
              $createdAt = Carbon::parse($post->created_at);
              $content['title'] = $post->title;
              $content['body']  = $this->trim_words($postContent, 500);
              $content['tags']  = $post->tags;
              $content['slug']  = $this->clean($post->slug);
              $content['image'] = $first_img;
              $content['date']  =  $createdAt->format('M jS, Y h:i A');;
              $content['id'] = $post->id;
              $content['username'] = $post->username;
              $content['user_img'] = $post->image;
    
              array_push($interestPosts,$content);
    
           }
        }
        return view('interest-posts')->with(['posts'=>$interestPosts,'interest'=>strtoupper($interest)]);
      }

    
}
