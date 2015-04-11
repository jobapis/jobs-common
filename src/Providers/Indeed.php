<?php namespace JobBrander\Jobs\Client\Providers;

use JobBrander\Jobs\Client\Job;

class Indeed extends AbstractProvider
{
    /**
     * Publisher Id
     *
     * @var string
     */
    protected $publisherId;

    /**
     * Version
     *
     * @var string
     */
    protected $version;

    /**
     * Highlight
     *
     * @var string
     */
    protected $highlight;

    /**
     * Returns the standardized job object
     *
     * @param array $payload
     *
     * @return \JobBrander\Jobs\Job
     */
    public function createJobObject($payload)
    {
        $defaults = ['jobtitle', 'company', 'formattedLocation', 'source',
            'date', 'snippet', 'url', 'jobkey'];

        $payload = static::parseAttributeDefaults($payload, $defaults);

        return new Job([
            'title' => $payload['jobtitle'],
            'companies' => $payload['company'],
            'locations' => $payload['formattedLocation'],
            'source' => $payload['source'],
            'dates' => $payload['date'],
            'description' => $payload['snippet'],
            'url' => $payload['url'],
            'id' => $payload['jobkey'],
        ]);
    }

    /**
     * Get data format
     *
     * @return string
     */
    public function getFormat()
    {
        return 'json';
    }

    /**
     * Get listings path
     *
     * @return  string
     */
    public function getListingsPath()
    {
        return 'results';
    }

    /**
     * Get parameters
     *
     * @return  array
     */
    public function getParameters()
    {
        return [];
    }

    /**
     * Get url
     *
     * @return  string
     */
    public function getUrl()
    {
        return 'http://api.indeed.com/ads/apisearch?'
            .'publisher='.$this->publisherId.'&'
            .'v='.$this->version.'&'
            .'highlight='.$this->highlight.'&'
            .'format='.$this->getFormat().'&'
            .'q='.urlencode($this->keyword).'&'
            .'l='.urlencode($this->city.', '.$this->state).'&'
            .'start='.$this->page.'&'
            .'limit='.$this->count;
    }

    /**
     * Get http verb
     *
     * @return  string
     */
    public function getVerb()
    {
        return 'GET';
    }
}
