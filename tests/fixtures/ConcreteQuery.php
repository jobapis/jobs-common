<?php namespace JobApis\Jobs\Client\Fixtures;

use JobApis\Jobs\Client\Queries\AbstractQuery;

class ConcreteQuery extends AbstractQuery
{
    /**
     * API Key
     *
     * @var string
     */
    protected $api_key;

    /**
     * Highlight
     *
     * @var string
     */
    protected $highlight;

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
     * Get baseUrl
     *
     * @return  string Value of the base url to this api
     */
    public function getBaseUrl()
    {
        return 'http://api.example.com/';
    }

    /**
     * Get keyword
     *
     * @return  string Attribute being used as the search keyword
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

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
     * Default parameters
     *
     * @var array
     */
    protected function defaultAttributes()
    {
        return array_merge(['highlight' => '1'], parent::defaultAttributes());
    }

    /**
     * Required parameters
     *
     * @var array
     */
    protected function requiredAttributes()
    {
        return array_merge(['api_key'], parent::requiredAttributes());
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
