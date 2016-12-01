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
     * @var AbstractQuery
     */
    protected $query;

    /**
     * Create new client
     *
     * @param array $parameters
     */
    public function __construct(AbstractQuery $query)
    {
        $this->setQuery($query)
            ->setClient(new HttpClient);
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
     * Job response object default keys that should be set
     *
     * @return  string
     */
    abstract public function getDefaultResponseFields();

    /**
     * Get listings path
     *
     * @return  string
     */
    abstract public function getListingsPath();

    /**
     * Uses the Query to make a call to the client
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getClientResponse()
    {
        // Create a local copy of the client object
        $client = $this->client;

        // GET or POST request
        $verb = strtolower($this->query->getVerb());

        // The URL string
        $url = $this->query->getUrl();

        // HTTP method options
        $options = $this->query->getHttpMethodOptions();

        // Get the response
        return $client->{$verb}($url, $options);
    }

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
     * Makes the api call and returns a collection of job objects
     *
     * @return  \JobApis\Jobs\Client\Collection
     * @throws MissingParameterException
     */
    public function getJobs()
    {
        // Verify that all required query vars are set
        if ($this->query->isValid()) {
            // Get the response from the client using the query
            $response = $this->getClientResponse();
            // Get the response body as a string
            $body = (string) $response->getBody();
            // Parse the string
            $payload = $this->parseAsFormat($body, $this->getFormat());
            // Gets listings if they're nested
            $listings = is_array($payload) ? $this->getRawListings($payload) : [];
            // Return a job collection
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
        $classSuffix = "Provider";

        $className = (new \ReflectionClass(get_class($this)))->getShortName();

        // Strip off the suffix from the provider
        if ($this->stringEndsWith($className, $classSuffix)) {
            $className = substr($className, 0, strlen($classSuffix));
        }

        return $className;
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
     * Sets query object
     *
     * @param AbstractQuery $query
     *
     * @return  AbstractProvider
     */
    public function setQuery(AbstractQuery $query)
    {
        $this->query = $query;

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
            $item = static::parseAttributeDefaults(
                $item,
                $this->getDefaultResponseFields()
            );
            $job = $this->createJobObject($item);
            $job->setQuery($this->query->getKeyword())
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

            $listings = self::getValue($index, $payload);

            // Listings should be returned as an array of arrays
            if (reset($listings) && is_array(reset($listings))) {
                return $listings;
            }
            return [0 => $listings];
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
     * Determine whether a string ends with another string
     *
     * @param $string
     * @param $test
     *
     * @return bool
     */
    private function stringEndsWith($string, $test)
    {
        $stringLen = strlen($string);
        $testLen = strlen($test);
        if ($testLen > $stringLen) return false;
        return substr_compare($string, $test, $stringLen - $testLen, $testLen) === 0;
    }
}
