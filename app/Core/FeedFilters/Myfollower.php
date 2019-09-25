<?php

namespace Lucid\Core\FeedFilters;
use DB;
use Auth;
use Illuminate\Support\Arr;

use Closure;
/**
 *
 */
class Myfollower extends Filter
{

  protected function applyFilter($builder)
  {
    $data= DB::table('following')->where('my_id', Auth::user()->id)->get('follower_id');
    //$data=[];
    $urlArray = json_decode($data, true);

      $urlArray2 = array(
          array('follower_id' => Auth::user()->id)
      );
     $result = array_merge($urlArray, $urlArray2);
//dd($result );
  $user= DB::table('users')->whereIn('id', Arr::flatten($result))->get('name');

  return $builder
  // ->join('users','extfeeds.site','=','users.name')
  // ->join('posts',['extfeeds.title' =>'posts.title','extfeeds.user_id'=> 'posts.user_id'])
  // ->select('extfeeds.*','posts.id as postsID','users.username','users.email','users.image as userImage')
  ->whereIn('site', Arr::pluck($user, 'name'));

  }

}
