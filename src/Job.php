<?php namespace JobBrander\Jobs;

class Job
{
    use AttributeTrait;

    protected $id;

    protected $title;

    protected $description;

    protected $source;

    protected $url;

    protected $query;

    protected $type;

    protected $companies;

    protected $locations;

    protected $industries;

    protected $dates;

    protected $salaries;

    protected $codes;

    public function __construct($attributes = [])
    {
        $this->createJobFromAttributes($attributes);
    }

    private function createJobFromAttributes($attributes = [])
    {
        array_walk($attributes, function ($value, $key) {
            $this->{$key} = $value;
        });
    }
}
