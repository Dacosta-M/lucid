<?php

namespace Lucid\Core\FeedFilters;

use Closure;
/**
 *
 */
class UserId extends Filter
{


protected function applyFilter($builder)
{
//  dd($builder->where('user_id', request('user_id')));
  return $builder->where($this->filterName(), request($this->filterName()));

}
}
