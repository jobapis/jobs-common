<?php namespace JobBrander\Jobs\Client;

class Job extends Schema\Entity\JobPosting
{
    use AttributeTrait;

    /**
     * Job Source
     *
     * @var string
     */
    protected $source;

    /**
     * Job Id
     *
     * @var string
     */
    protected $sourceId;

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
     * Job Dates
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Job Salaries
     *
     * @var array
     */
    protected $salaries = [];

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

    /**
     * Sets query.
     *
     * @param string $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Gets query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Sets source.
     *
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Gets source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets sourceId.
     *
     * @param int $sourceId
     *
     * @return $this
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Gets sourceId.
     *
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Sets type.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Gets type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
