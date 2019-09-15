<?php
namespace Lucid\Core;
use Auth;
use Storage;
use Lucid\Following;
use DB;


/**
 *
 */
class Subscribe
{
  var $name;
  var $rss;
  var $img;
  var $desc;
  var $link;

  protected $user;

  public function __construct($user)
  {

      $this->user  = $user;
  }

  public function file()
  {
      return $this->file;
  }


  public function setSubName($value)
  {
    $this->name = $value;
  }
  public function setSubRss($value)
  {
    $this->rss = $value;
  }
  public function setSubDesc($value)
  {
    $this->desc = $value;
  }
  public function setSubLink($value)
  {
    $this->link = $value;
  }
  public function setSubImg($value)
  {
    $this->img = $value;
  }
    public function fix()
  {
    $getc = DB::table('ext_rsses')->get();
    $get = DB::table('ext_rsses')->take(500)->get();
    foreach ($get as $key => $value) {
    //  dd($value->title);
if (DB::table('users')->where('name', $value->title)->exists() == 1) {
    $user = DB::table('users')->where('name', $value->title)->first();

    $action = DB::table('following')->insert([
          'my_id'          => $value->user_id,
          'follower_id'    => $user->id,
          'status'         => 1
      ]);
      if ($action) {
        DB::table('ext_rsses')->where(["title" => $value->title, 'user_id' =>$value->user_id])->delete();

      }
      }
      DB::table('ext_rsses')->where(["title" => $value->title, 'user_id' =>$value->user_id])->delete();

  }

  $all = count($getc);
  echo 'A total of '.$all." undo, the first 500 done, refresh till done";
  //  \Schema::dropIfExists('ext_rsses');
  //  var_dump($action);
//return;
  }

public function extract($url)
{
  $rss = new \DOMDocument();
  $user = DB::table('users')->where('username', $url)->first();
  $me = Auth::user();

                $follow = $this->findOrCreateRss(
                  $me['id'],
                  $user->id,
                  0
                );

                if ($follow) {
                  $createComment = DB::table('notifications')->insert([

                    'sender_id'=> $me['id'],
                    'user_id'=> $user->id,
                    'status'=> 0,
                    'action'=>"Followed",
                    'type'=>"Following",
                  ]);
                }

  }

  public function extractPub($url)
  {
    $rss = new \DOMDocument();

    //if (!$url = file_get_contents($url)) {
    //  return false;
      //  } else {

          //$url = storage_path('app/'.$url."/rss/rss.xml");

        echo ($url);
        $rss->load(trim($url));
        foreach ($rss->getElementsByTagName('channel') as $r) {
          $title = $r->getElementsByTagName('title')->item(0)->nodeValue;

          $link = $r->getElementsByTagName('link')->item(0)->nodeValue;
          $description = $r->getElementsByTagName('description')->item(0)->nodeValue;

          $image = isset($r->getElementsByTagName('url')->item(0)->nodeValue) ?
                    $r->getElementsByTagName('url')->item(0)->nodeValue : '';

          $lastbuild =isset( $r->getElementsByTagName('lastBuildDate')->item(0)->nodeValue ) ?
                        $r->getElementsByTagName('lastBuildDate')->item(0)->nodeValue : '';


        }

                $this->setSubName($title);
                $this->setSubRss($url);
                $this->setSubDesc($description);
                $this->setSubImg($image);
                $this->setSubLink($link);

                  $this->findOrCreateRss(
                    $this->name,
                    $url,
                    $this->desc,
                    $this->link,
                    $this->img,
                    $lastbuild

                  );

              //  }
    }

  public function findOrCreateRss($me, $them, $stat){

      $user = Auth::user();

    return DB::table('following')->insert([
          'my_id'          => $me,
          'follower_id'    => $them,
          'status'         => $stat
      ]);

  }



  
  public function unfollow($del)
  {
$fuser= DB::table('users')->where('name', $del)->get('id')->first();

$user = Auth::user();

  $file= DB::table('following')->where('my_id', $user->id)->where('follower_id', $fuser->id)->delete();

//  dd($file);
return $file;

  }
  public function count()
  {

    $user= DB::table('users')->where('username', $this->user)->get('id')->first();
  //  $user=json_decode($user,true);
    $name= DB::table('following')->where('my_id', $user->id)->get('follower_id');
$fuser = [];
    foreach($name as $key => $id){
    //  dd($id->follower_id);
      $user= DB::table('users')->where('id', $id->follower_id)->get();
    //  dd(  $user);
      foreach($user as $key => $user){
    //  $content['name'] = $user->name;
    array_push($fuser, $user->name);
    }
}
  //  $data=json_decode($file,true);
  //  dd($fuser);
    if(!empty($fuser)){
      unset($user_id);
      return $fuser;
    }
  }
  public function myfollowercount()
  {
  //  $user = Auth::user();
      $user= DB::table('users')->where('username', $this->user)->first();
      $data= DB::table('following')->where('follower_id', $user->id)->get();
      $data = json_decode($data, true);

        $follower = [];
        foreach ($data as $key => $value) {

          $follow = DB::table('users')->where('id', $value['my_id'])->get();
        //  dd($value);

           foreach($follow as $key => $follow){

          $content['name'] = $follow->name;
          $content['username'] = $follow->username;
          $content['img'] = $follow->image;
          $content['id'] = $follow->id;
          $content['desc'] = $follow->short_bio;
          array_push($follower, $content);

      }
        }
        if(!empty($data)){
          unset($data);
        return $follower;
    //  return $data;

    }


  }
}
