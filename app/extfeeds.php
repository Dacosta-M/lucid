<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class extfeeds extends Model
{

  /**
 * The table associated with the model.
 *
 * @var string
 */
  protected $fillable = [
    'user_id',
    'site',
    'site_image',
    'title',
    'des',
    'link',
    'date',
    'image'
  ];
  public static function allFeeds()
  {

    return $posts = app(Pipeline::class)
    ->send(extfeeds::query())
    ->through([
      \Lucid\Core\FeedFilters\UserId::class,
      \Lucid\Core\FeedFilters\Sort::class,
      //\Lucid\Core\FeedFilters\Myfollower::class,
    ])
    ->thenReturn()
    ->paginate(1);
  }

  public static function myFeeds()
  {
    return $posts = app(Pipeline::class)
    ->send(extfeeds::query())
    ->through([
      \Lucid\Core\FeedFilters\Sort::class,
      \Lucid\Core\FeedFilters\Myfollower::class,
    ])
    ->thenReturn()
    ->simplePaginate(2);
  }
  public static function userFeeds($username)
  {
    return $posts = app(Pipeline::class)
    ->send(extfeeds::query())
    ->through([
      \Lucid\Core\FeedFilters\Sort::class,
    new  \Lucid\Core\FeedFilters\userFeeds($username),
    ])
    ->thenReturn()
    ->simplePaginate(5);
  }

  public function user()
  {
    $this->belongsTo(User::class);
  }
}
