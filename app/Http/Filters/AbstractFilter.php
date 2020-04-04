<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class AbstractFilter
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Additional filters
     * @var array
     */
    protected $additional = [];
    /**
     * Create a new ThreadFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter => $value) {
            $filter = $this->normalizeFilterName($filter);
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        $this->order();
        return $this->builder;
    }

    public function order()
    {
        //
    }

    public function getFilters()
    {
        if ($this->request->has('query')) {
            return json_decode($this->request->get('query', []), true) ?? [];
        }

        return  array_merge($this->fromRequest(), $this->additional);
    }

    protected function fromRequest()
    {
        return array_filter($this->request->only($this->filters));
    }

    public function additional($key, $value)
    {
        $this->additional[$key] = $value;
        return $this;
    }

    protected function normalizeFilterName($filter)
    {
        return Str::camel($filter);
    }
}
