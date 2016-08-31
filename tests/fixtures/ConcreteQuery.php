<?php namespace JobApis\Jobs\Client\Fixtures;

use JobApis\Jobs\Client\Queries\AbstractQuery;

class ConcreteQuery extends AbstractQuery
{
    /**
     * API Key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Base API Url
     *
     * @var string
     */
    protected $baseUrl = 'http://api.example.com/';

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
        return [
            'highlight' => '1',
        ];
    }

    /**
     * Required parameters
     *
     * @var array
     */
    protected function requiredAttributes()
    {
        return [
            'api_key',
        ];
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
