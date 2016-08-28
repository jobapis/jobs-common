<?php namespace JobApis\Jobs\Client\Providers;

use GuzzleHttp\Client as HttpClient;
use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\Exceptions\MissingParameterException;
use JobApis\Jobs\Client\Queries\AbstractQuery;

abstract class AbstractProvider
{
    /**
     * HTTP Client
     *
     * @var HttpClient
     */
    protected $client;

    /**
     * Query params
     *
     * @var array
     */
    protected $query;

    /**
     * Create new client
     *
     * @param array $parameters
     */
    public function __construct(AbstractQuery $query)
    {
        $this->query = $query;
        $this->setClient(new HttpClient);
    }

    /**
     * Returns the standardized job object
     *
     * @param array|object $payload
     *
     * @return \JobApis\Jobs\Client\Job
     */
    abstract public function createJobObject($payload);

    /**
     * Get default parameters and values
     *
     * @return  string
     */
    abstract public function defaultParameters();

    /**
     * Job object default keys that must be set.
     *
     * @return  string
     */
    abstract public function defaultResponseFields();

    /**
     * Get listings path
     *
     * @return  string
     */
    abstract public function getListingsPath();

    /**
     * Get parameters that MUST be set in order to satisfy the APIs requirements
     *
     * @return  string
     */
    abstract public function requiredParameters();

    /**
     * Get parameters that CAN be set
     *
     * @return  string
     */
    abstract public function validParameters();

    /**
     * Get format
     *
     * @return  string Currently only 'json' and 'xml' supported
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
            $options['body'] = $this->queryParams;
        }

        return $options;
    }

    /**
     * Makes the api call and returns a collection of job objects
     *
     * @return  \JobApis\Jobs\Client\Collection
     * @throws MissingParameterException
     */
    public function getJobs()
    {
        if ($this->requiredParamsIncluded()) {
            $client = $this->client;
            $verb = strtolower($this->getVerb());
            $url = $this->getUrl();
            $options = $this->getHttpClientOptions();

            $response = $client->{$verb}($url, $options);

            $body = (string) $response->getBody();

            $payload = $this->parseAsFormat($body, $this->getFormat());

            $listings = is_array($payload) ? $this->getRawListings($payload) : [];

            return $this->getJobsCollectionFromListings($listings);
        } else {
            throw new MissingParameterException("All Required parameters for this provider must be set");
        }
    }

    /**
     * Get source attribution
     *
     * @return string
     */
    public function getSource()
    {
        return $this->getShortName();
    }

    /**
     * Get query string for client based on properties
     *
     * @return string
     */
    public function getQueryString()
    {
        return '?'.http_build_query($this->queryParams);
    }

    /**
     * Get url
     *
     * @return  string
     */
    public function getUrl()
    {
        if (!$this->baseUrl) {
            throw new MissingParameterException("Base URL parameter not set in provider.");
        }
        return $this->baseUrl.$this->getQueryString();
    }

    /**
     * Get http verb to use when making request
     *
     * @return  string
     */
    public function getVerb()
    {
        return 'GET';
    }

    /**
     * Check whether a key is valid for this client
     *
     * @return  string
     */
    public function isValidParameter($key = null)
    {
        return in_array($key, $this->validParameters());
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
     * Parse location string into components.
     *
     * @param string $location
     *
     * @return  array
     **/
    public static function parseLocation($location, $separator = ', ')
    {
        return explode($separator, $location);
    }

    /**
     * Determines if all required parameters have been set
     *
     * @return  bool
     */
    public function requiredParamsIncluded()
    {
        foreach ($this->requiredParameters() as $key) {
            if (!isset($this->queryParams[$key])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Sets http client
     *
     * @param HttpClient $client
     *
     * @return  AbstractProvider
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Create and get collection of jobs from given listings
     *
     * @param  array $listings
     *
     * @return Collection
     */
    protected function getJobsCollectionFromListings(array $listings = [])
    {
        $collection = new Collection;

        array_map(function ($item) use ($collection) {
            $item = static::parseAttributeDefaults($item, $this->defaultResponseFields());
            $job = $this->createJobObject($item);
            $job->setQuery($this->getKeyword())
                ->setSource($this->getSource());
            $collection->add($job);
        }, $listings);

        return $collection;
    }

    /**
     * Get raw listings from payload
     *
     * @param  array $payload
     *
     * @return array
     */
    protected function getRawListings(array $payload = array())
    {
        $path = $this->getListingsPath();

        if (!empty($path)) {
            $index = explode('.', $path);

            return (array) self::getValue($index, $payload);
        }

        return (array) $payload;
    }

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
        $current_index = self::getValueCurrentIndex($index);

        if (isset($value[$current_index])) {
            $index_array = self::isArrayNotEmpty($index);
            $value_array = self::isArrayNotEmpty($value[$current_index]);

            if ($index_array && $value_array) {
                return self::getValue($index, $value[$current_index]);
            } else {
                return $value[$current_index];
            }
        } else {
            throw new \OutOfRangeException("Attempt to access missing variable: $current_index");
        }
    }

    /**
     * Attempt to parse string as given format
     *
     * @param  string  $string
     * @param  string  $format
     *
     * @return array
     */
    protected function parseAsFormat($string, $format)
    {
        $method = 'parseAs'.ucfirst(strtolower($format));

        if (method_exists($this, $method)) {
            return $this->$method($string);
        }

        return [];
    }

    /**
     * Get value current index
     *
     * @param  mixed $index
     *
     * @return array|null
     */
    private static function getValueCurrentIndex(&$index)
    {
        return is_array($index) && count($index) ? array_shift($index) : null;
    }

    /**
     * Checks if given value is an array and that it has contents
     *
     * @param  mixed $array
     *
     * @return boolean
     */
    private static function isArrayNotEmpty($array)
    {
        return is_array($array) && count($array);
    }

    /**
     * Attempt to parse as Json
     *
     * @param  string $string
     *
     * @return array
     */
    private function parseAsJson($string)
    {
        try {
            $json = json_decode($string, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                throw new \Exception;
            }

            return $json;
        } catch (\Exception $e) {
            // Ignore malformed json.
        }

        return [];
    }

    /**
     * Attempt to parse as XML
     *
     * @param  string $string
     *
     * @return array
     */
    private function parseAsXml($string)
    {
        try {
            return json_decode(
                json_encode(
                    simplexml_load_string(
                        $string,
                        null,
                        LIBXML_NOCDATA
                    )
                ),
                true
            );
        } catch (\Exception $e) {
            // Ignore malformed xml.
        }

        return [];
    }

    /**
     * Get short name of a given or current class
     *
     * @param  object $object Optional object
     *
     * @return string
     */
    private function getShortName($object = null)
    {
        if (is_null($object)) {
            $object = $this;
        }

        $ref = new \ReflectionClass(get_class($object));

        return $ref->getShortName();
    }
}
