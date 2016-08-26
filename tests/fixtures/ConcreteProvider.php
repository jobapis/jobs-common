<?php namespace JobApis\Jobs\Client\Fixtures;

use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\Exceptions\MissingParameterException;
use JobApis\Jobs\Client\Job;
use JobApis\Jobs\Client\Providers\AbstractProvider;

class ConcreteProvider extends AbstractProvider
{
    /**
     * Base API Url
     *
     * @var string
     */
    protected $baseUrl = 'http://api.example.com/';

    /**
     * Returns the standardized job object
     *
     * @param array|object $payload
     *
     * @return \JobApis\Jobs\Client\Job
     */
    public function createJobObject($payload) {
        $job = new Job([
            'title' => $payload['name'],
            'name' => $payload['name'],
            'description' => $payload['snippet'],
            'url' => $payload['url'],
            'sourceId' => $payload['id'],
        ]);
        return $job->setCompany($payload['company'])
            ->setDatePostedAsString($payload['date']);
    }

    /**
     * Simulates making an api call and returning a collection of job objects
     *
     * @return  Collection
     * @throws MissingParameterException
     */
    public function getJobs()
    {
        if ($this->requiredParamsIncluded()) {
            $body = json_encode([
                'jobs' => [
                    0 => [
                        'id' => uniqid(),
                        'name' => uniqid(),
                        'company' => uniqid(),
                        'date' => date('m/d/y'),
                        'url' => uniqid(),
                    ],
                    1 => [
                        'id' => uniqid(),
                        'name' => uniqid(),
                        'company' => uniqid(),
                        'date' => date('m/d/y'),
                        'url' => uniqid(),
                    ],
                ]
            ]);

            $payload = $this->parseAsFormat($body, $this->getFormat());

            $listings = is_array($payload) ? $this->getRawListings($payload) : [];

            return $this->getJobsCollectionFromListings($listings);
        } else {
            throw new MissingParameterException("All Required parameters for this provider must be set");
        }
    }

    /**
     * Get default parameters and values
     *
     * @return  string
     */
    public function defaultParameters() {
        return [
            'ipAddress' => $this->currentUserIpAddress(),
        ];
    }

    /**
     * Job object default keys that should be set
     *
     * @return  string
     */
    public function defaultResponseFields()
    {
        return [
            'id',
            'name',
            'company',
            'date',
            'snippet',
            'url',
        ];
    }

    /**
     * Get listings path
     *
     * @return  string
     */
    public function getListingsPath() {
        return 'jobs';
    }

    /**
     * Get parameters that MUST be set in order to satisfy the APIs requirements
     *
     * @return  string
     */
    public function requiredParameters() {
        return [
            'keyword',
            'ipAddress',
            'affiliateId',
        ];
    }

    /**
     * Get parameters that CAN be set
     *
     * @return  string
     */
    public function validParameters() {
        return [
            'keyword',
            'ipAddress',
            'affiliateId',
            'optionalParam1',
            'optionalParam2',
        ];
    }

    public function currentUserIpAddress()
    {
        return uniqid();
    }

    /**
     * Get optional parameter. Demonstrates simple transformation on getter.
     *
     * @return  string
     */
    public function getOptionalParam2()
    {
        return strrev($this->optionalParam2);
    }

    /**
     * Set optional parameter. Demonstrates simple transformation on setter.
     *
     * @return  string
     */
    public function setOptionalParam1($value)
    {
        $this->optionalParam1 = strrev($value);
        return $this;
    }

}
