<?php

namespace App\Models\Traits;

use App\Http\Filters\AbstractFilter;

trait Searchable
{
    public function scopeFilter($query, AbstractFilter $filters)
    {
        return $filters->apply($query);
    }
}
