<?php

namespace Lucid\Core\FeedFilters;
use DB;
use Auth;
use Illuminate\Support\Arr;

use Closure;
/**
 *
 */
class userFeeds extends Filter
{


  private $username;


public function __construct($username)
{
  $this->username = $username;

}
  protected function applyFilter($builder)
  {
  $user= DB::table('users')->where('username', $this->username)->get('name');
  

  return $builder
  ->join('users','extfeeds.site','=','users.name')
  ->join('posts',['extfeeds.title' =>'posts.title','extfeeds.user_id'=> 'posts.user_id'])
  ->select('extfeeds.*','posts.id as postsID','users.username','users.email','users.image as userImage')
  ->whereIn('site', Arr::pluck($user, 'name'));

  }

}
