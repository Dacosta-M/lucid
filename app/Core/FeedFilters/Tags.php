<?php

namespace Lucid\Core\FeedFilters;

use Closure;
/**
 *
 */
class Tags extends Filter
{


protected function applyFilter($builder)
{

  $t = request('tags');
  return $builder->where("extfeeds.".$this->filterName(), 'like', "%$t%" );

}
}
