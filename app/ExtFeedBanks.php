<?php

namespace Lucid;

use Illuminate\Database\Eloquent\Model;

class ExtFeedBanks extends Model
{

  protected $fillable = [
    'site',
    'site_image',
    'title',
    'des',
    'link',
    'date',
    'image'
  ];
}
