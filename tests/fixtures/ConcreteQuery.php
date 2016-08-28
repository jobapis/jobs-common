<?php namespace JobApis\Jobs\Client\Fixtures;

use JobApis\Jobs\Client\Queries\AbstractQuery;

class ConcreteQuery extends AbstractQuery
{
    /**
     * Base API Url
     *
     * @var string
     */
    protected $baseUrl = 'http://api.example.com/';

    /**
     * Default query parameters
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Keyword
     *
     * @var string
     */
    protected $keyword;

    /**
     * Sample attribute 1
     *
     * @var string
     */
    protected $sampleAttribute1;

    /**
     * Sample attribute 2
     *
     * @var string
     */
    protected $sampleAttribute2;

    /**
     * Custom method to get sample attribute 2
     *
     * @var string
     */
    protected function getSampleAttribute2()
    {
        return strrev($this->sampleAttribute2);
    }

    /**
     * Custom method to set sample attribute 1
     *
     * @var string
     */
    protected function setSampleAttribute1($value)
    {
        $this->sampleAttribute1 = strrev($value);
        return $this;
    }

}
