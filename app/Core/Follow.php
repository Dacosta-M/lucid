<?php


namespace Lucid\Core;

use DB;
use Auth;


/**
 *
 */
class Follow
{

  function __construct($username)
  {
    $this->user = $username;
  }



  public function subscription($user)
  {
    $this->user = $user;
  //  dd($this->user);
    //$user = Auth::user();
  $user =   DB::table('users')->where('username', $this->user)->first();
    $data= DB::table('following')->where('my_id', $user->id)->get();
    $data = json_decode($data, true);

  //  dd($data);
      $following = [];
      foreach ($data as $key => $value) {
$follower= DB::table('users')->where('id', $value['follower_id'])->get();
        foreach($follower as $key => $follower){
        $content['name'] = $follower->name;
        $content['username'] = $follower->username;
        $content['img'] = $follower->image;
        $content['id'] = $follower->id;
        $content['desc'] = $follower->short_bio;
          array_push($following, $content);
      }
    }
    //  dd( $following);
      return $following;
  }
  //code for returnng details of each codes


  public function subscriber($user)
  {

    $user =   DB::table('users')->where('username', $this->user)->first();

    $data= DB::table('following')->where('follower_id', $user->id)->get();
    $data = json_decode($data, true);
    //  dd($data);

    $follower = [];
    foreach ($data as $key => $value) {

      $follow = DB::table('users')->where('id', $value['my_id'])->get();

      foreach($follow as $key => $follow){

        $content['name'] = $follow->name;
        $content['username'] = $follow->username;
        $content['img'] = $follow->image;
        $content['id'] = $follow->id;
        $content['desc'] = $follow->short_bio;
        array_push($follower, $content);

      }
    }
    return $follower;
  }





  public function followerArray()
  {
    //$user= DB::table('users')->where('username', $value)->get();

    $check = new Subscribe(Auth::user()->username);
    //dd(Auth::user()->username);
    $title = [];
    if (!is_null($check->count())) {

    foreach($check->count() as $key => $fuser){
    //  dd($fuser);
    array_push($title , $fuser);
  }
//dd($title );
}
return $title;

  }
  public function followCheck($value)
  {
    $this->user = $value;
$title = $this->followerArray();


                      if (in_array($value, $title)) {
                        $fcheck = "yes";
                      }else {
                        $fcheck = "no";
                      }
                    return $fcheck;
    }

    public function subc($url)
    {
      $rss = new \DOMDocument();


          $rss->load(trim($url));
          foreach ($rss->getElementsByTagName('channel') as $r) {
            $title = $r->getElementsByTagName('title')->item(0)->nodeValue;
            $link = $r->getElementsByTagName('link')->item(0)->nodeValue;
            $description = $r->getElementsByTagName('description')->item(0)->nodeValue;
            if (is_null($r->getElementsByTagName('image')->item(0)->nodeValue)) {
            $image ="resources/themes/ghost/secure_asset/img/bubbles.png";
          }else {
            $image = $r->getElementsByTagName('url')->item(0)->nodeValue;

          }

          }


                  $db = "storage/rss/subscriber.json";

                  $file = FileSystem::read($db);
                  $data=json_decode($file, true);
                  unset($file);

                  if (count($data) >= 1) {

                  foreach ($data as $key => $value) {
                     if ($value["name"] == $title) {

                       $message= "false";

                       break;
                     }else {
                       $message= "true";

                     }


                  }
                  if ($message == "true") {

                  //  $db_json = file_get_contents("storage/rss/subscriber.json");

                    $time = date("Y-m-d h:i:sa");
                      $img = $image;
                      $sub[] = array('name'=> $title, 'rss'=>$url,'desc'=>$description, 'link'=>$link, 'img'=> $image, 'time' => $time);

                      $json_db = "storage/rss/subscriber.json";
                      $file = file_get_contents($db);
                      $prev_sub = json_decode($file);
                      $new =array_merge($sub, $prev_sub);
                      $new = json_encode($new);
                      $doc = FileSystem::write($json_db, $new);
    }
                  }else {
                  $time = date("Y-m-d h:i:sa");
                  $img = $image;
                  $sub[] = array('name'=> $title, 'rss'=>$url,'desc'=>$description, 'link'=>$link, 'img'=> $image, 'time' => $time);

                  $json_db = "storage/rss/subscriber.json";
                  $file = file_get_contents($db);
                  $prev_sub = json_decode($file);

                  $new = array_merge($sub, $prev_sub);
                  $new = json_encode($new);
                  $doc = FileSystem::write($json_db, $new);


              }
              //header("loaction: /subscriptions");
      }
}
