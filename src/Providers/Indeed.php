<?php namespace JobBrander\Jobs\Providers;

use JobBrander\Jobs\Job;

class Indeed extends AbstractClient
{
    protected $publisherId;
    protected $version;
    protected $highlight;

    /**
     * Returns the standardized job object
     *
     * @param array $payload
     *
     * @return JobBrander\Jobs\Job
     */
    public function createJobObject($payload)
    {
        $payload = $this->parseDefaults($payload);

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

    /**
     * [parseDefaults description]
     *
     * @param  [type]  [description]
     *
     * @return [type]  [description]
     */
    private function parseDefaults($attributes)
    {
        $defaults = ['jobtitle', 'company', 'formattedLocation', 'source',
            'date', 'snippet', 'url', 'jobkey'];

        array_map(function ($attribute) use (&$attributes) {
            if (!isset($attributes[$attribute])) {
                $attributes[$attribute] = null;
            }
        }, $defaults);

        return $attributes;
    }
}
