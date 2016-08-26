<?php namespace JobApis\Jobs\Client\Fixtures;

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
    public function createJobObject($payload) {}

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
    public function getRequiredParameters() {
        return [
            'keyword',
            'ipAddress',
            'affiliateUrl',
        ];
    }

    /**
     * Get parameters that CAN be set
     *
     * @return  string
     */
    public function getValidParameters() {
        return [
            'keyword',
            'ipAddress',
            'affiliateUrl',
            'optionalParam1',
            'optionalParam2',
        ];
    }

}
