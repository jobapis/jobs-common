<?php namespace JobApis\Jobs\Client\Fixtures;

use JobApis\Jobs\Client\Job;
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
     * Get listings path
     *
     * @return  string
     */
    public function getListingsPath() {
        return 'jobs';
    }
}
