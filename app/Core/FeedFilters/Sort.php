<?php

namespace Lucid\Core\FeedFilters;

use Closure;
/**
 *
 */
class Sort extends Filter
{

  protected function applyFilter($builder)
  {
  return $builder->orderBy('id', request($this->filterName()));
  }

}
