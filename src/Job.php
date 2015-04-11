<?php namespace JobBrander\Jobs;

class Job
{
    use AttributeTrait;

    /**
     * Job Id
     *
     * @var string
     */
    protected $id;

    /**
     * Job Title
     *
     * @var string
     */
    protected $title;

    /**
     * Job Description
     *
     * @var string
     */
    protected $description;

    /**
     * Job Source
     *
     * @var string
     */
    protected $source;

    /**
     * Job Url
     *
     * @var string
     */
    protected $url;

    /**
     * Job Query
     *
     * @var string
     */
    protected $query;

    /**
     * Job Type
     *
     * @var string
     */
    protected $type;

    /**
     * Job Companies
     *
     * @var array
     */
    protected $companies;

    /**
     * Job Locations
     *
     * @var array
     */
    protected $locations;

    /**
     * Job Industries
     *
     * @var array
     */
    protected $industries;

    /**
     * Job Dates
     *
     * @var array
     */
    protected $dates;

    /**
     * Job Salaries
     *
     * @var array
     */
    protected $salaries;

    /**
     * Job Codes
     *
     * @var array
     */
    protected $codes;

    /**
     * Create new job
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        array_walk($attributes, function ($value, $key) {
            $this->{$key} = $value;
        });
    }
}
