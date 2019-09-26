<?php

namespace Lucid\Core\FeedFilters;
use DB;
use Auth;
use Lucid\ExtFeedBanks;
use Illuminate\Support\Arr;

use Closure;
/**
 *
 */
class Rss extends Filter
{

  protected function applyFilter($builder)
  {
      if (request('tags') == null) {
        $tabs = 'main';
      }else {
        $tabs = request('tags');
      }
     $data= DB::table('ext_rsses')
     ->where(['user_id'=> Auth::user()->id,'category' => $tabs])
     ->get();
     $urlArray = json_decode($data, true);

     $rss = ExtFeedBanks::whereIn("site",Arr::flatten($urlArray));
    // dd(request('tags'));

   return $builder->union($rss);

  }

}
