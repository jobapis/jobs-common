<?php namespace JobApis\Jobs\Client\Test;

use JobApis\Jobs\Client\Providers\AbstractProvider;

class ConcreteProvider extends AbstractProvider
{
    /**
     * Returns the standardized job object
     *
     * @param array|object $payload
     *
     * @return \JobApis\Jobs\Client\Job
     */
    public function createJobObject($payload) {}

    /**
     * Get format
     *
     * @return  string Currently only 'json' and 'xml' supported
     */
    public function getFormat() {}

    /**
     * Get listings path
     *
     * @return  string
     */
    public function getListingsPath() {}

    /**
     * Get keyword for search query
     *
     * @return string Should return the value of the parameter describing this query
     */
    public function getKeyword() {}

    /**
     * Get http verb to use when making request
     *
     * @return  string
     */
    public function getVerb() {}

}
