<?php namespace JobBrander\Jobs\Client;

/**
 * @method Job addCompanies($value)
 * @method Job addLocations($value)
 * @method Job addIndustries($value)
 * @method Job addCodes($value)
 * @method Job getId()
 * @method Job getTitle()
 * @method Job getDescription()
 * @method Job getSource()
 * @method Job getUrl()
 * @method Job getQuery()
 * @method Job getType()
 * @method Job getCompanies($value)
 * @method Job getLocations($value)
 * @method Job getIndustries($value)
 * @method Job getStartDate()
 * @method Job getEndDate()
 * @method Job getMinimumSalariy()
 * @method Job getMaximumSalariy()
 * @method Job getCodes()
 * @method Job setId($value)
 * @method Job setTitle($value)
 * @method Job setDescription($value)
 * @method Job setSource($value)
 * @method Job setUrl($value)
 * @method Job setQuery($value)
 * @method Job setType($value)
 * @method Job setStartDate($value)
 * @method Job setEndDate($value)
 * @method Job setMinimumSalary($value)
 * @method Job setMaximumSalary($value)
 * @method Job setCompanies($value)
 * @method Job setLocations($value)
 * @method Job setIndustries($value)
 * @method Job setCodes($value)
 */
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
     * Job Start Date
     *
     * @var string
     */
    protected $startDate;

    /**
     * Job End Date
     *
     * @var string
     */
    protected $endDate;

    /**
     * Job Minimum Salary
     *
     * @var array
     */
    protected $minimumSalary;

    /**
     * Job Maximum Salary
     *
     * @var array
     */
    protected $maximumSalary;

    /**
     * Job Companies
     *
     * @var array
     */
    protected $companies = [];

    /**
     * Job Locations
     *
     * @var array
     */
    protected $locations = [];

    /**
     * Job Industries
     *
     * @var array
     */
    protected $industries =[];

    /**
     * Job Codes
     *
     * @var array
     */
    protected $codes = [];

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
