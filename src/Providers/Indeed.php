<?php namespace JobBrander\Jobs\Providers;

use JobBrander\Jobs\Job;

class Indeed extends AbstractClient
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
     * Get listings path
     *
     * @return  string
     */
    protected function getListingsPath()
    {
        return 'results';
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
}
