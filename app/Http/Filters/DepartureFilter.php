<?php

namespace App\Http\Filters;

class DepartureFilter extends AbstractFilter
{
    protected $filters = ['from', 'to'];

    public function from($value)
    {
        return $this->builder->where('from_id', $value);
    }

    public function to($value)
    {
        return $this->builder->where('to_id', $value);
    }
}
