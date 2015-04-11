<?php namespace JobBrander\Jobs\Providers;

use GuzzleHttp\Client as HttpClient;
use JobBrander\Jobs\AttributeTrait;
use JobBrander\Jobs\Collection;

abstract class AbstractClient
{
    use AttributeTrait;

    /**
     * City
     *
     * @var string
     */
    protected $city = null;

    /**
     * Http client
     *
     * @var HttpClient
     */
    private $client;

    /**
     * Count
     *
     * @var integer
     */
    protected $count = 10;

    /**
     * Keyword
     *
     * @var string
     */
    protected $keyword = null;

    /**
     * Page
     *
     * @var integer
     */
    protected $page = 1;

    /**
     * State
     *
     * @var string
     */
    protected $state = null;

    /**
     * Create new client
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        array_walk($parameters, function ($value, $key) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        });

        $this->setClient(new HttpClient);
    }

    /**
     * Returns the standardized job object
     *
     * @param array|object $payload
     *
     * @return \JobBrander\Jobs\Job
     */
    abstract public function createJobObject($payload);

    /**
     * Get format
     *
     * @return  string
     */
    public function getFormat()
    {
        return 'json';
    }

    /**
     * Get http client options based on current client
     *
     * @return array
     */
    public function getHttpClientOptions()
    {
        $options = [];
        if (strtolower($this->getVerb()) != 'get') {
            $options['body'] = $this->getParameters();
        }

        return $options;
    }

    /**
     * Makes the api call and returns a collection of job objects
     *
     * @return  JobBrander\Jobs\Collection
     */
    public function getJobs()
    {
        $client = $this->client;
        $verb = strtolower($this->getVerb());
        $url = $this->getUrl();
        $options = $this->getHttpClientOptions();

        $response = $client->{$verb}($url, $options);

        $payload = $response->{$this->getFormat()}();

        $listings = $this->getRawListings($payload);

        $collection = new Collection;

        array_map(function ($item) use ($collection) {
            $job = $this->createJobObject($item);
            $job->setQuery($this->keyword);
            $collection->add($job);
        }, $listings);

        return $collection;
    }

    /**
     * Get listings path
     *
     * @return  string
     */
    protected function getListingsPath()
    {
        return '';
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
     * Get raw listings from payload
     *
     * @param  array $payload
     *
     * @return array
     */
    protected function getRawListings($payload = [])
    {
        $path = $this->getListingsPath();

        if (!empty($path)) {
            $index = explode('.', $path);

            return (array) self::getValue($index, $payload);
        }

        return (array) $payload;
    }

    /**
     * Get url
     *
     * @return  string
     */
    abstract public function getUrl();

    /**
     * Navigate through a payload array looking for a particular index
     *
     * @param array $index The index sequence we are navigating down
     * @param array $value The portion of the config array to process
     *
     * @return mixed
     */
    protected static function getValue($index, $value)
    {
        $current_index = 0;

        if (is_array($index) &&
            count($index)) {
            $current_index = array_shift($index);
        }

        if (is_array($index) &&
            count($index) &&
            isset($value[$current_index]) &&
            is_array($value[$current_index]) &&
            count($value[$current_index])) {
            return self::getValue($index, $value[$current_index]);
        } elseif (isset($value[$current_index])) {
            return $value[$current_index];
        } else {
            throw new \OutOfRangeException("Attempt to access missing variable: $current_index");
        }
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

    /**
     * Parse job attributes against defaults
     *
     * @param  array $attributes
     * @param  array $defaults
     *
     * @return array
     */
    public static function parseAttributeDefaults(array $attributes, array $defaults = array())
    {
        array_map(function ($attribute) use (&$attributes) {
            if (!isset($attributes[$attribute])) {
                $attributes[$attribute] = null;
            }
        }, $defaults);

        return $attributes;
    }

    /**
     * Sets http client
     *
     * @param HttpClient $client
     *
     * @return  AbstractClient
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }
}
