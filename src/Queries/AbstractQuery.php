<?php namespace JobApis\Jobs\Client\Queries;

use JobApis\Jobs\Client\Exceptions\MissingParameterException;

abstract class AbstractQuery
{
    /**
     * Base API Url
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Default query parameters
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Create new query from parameters
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        $parameters = array_flip(array_merge($this->defaults, $parameters));

        array_walk($parameters, [$this, 'set']);
    }

    /**
     * Get query param as properties, if exists
     *
     * @param  string $name
     *
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function __get($key)
    {
        // Then check to see if there's a query parameter
        if (!$this->isValidParameter($key)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $key
            ));
        }
        return $this->queryParams[$key];
    }

    /**
     * Set query param as properties, if exists
     *
     * @param  string $name
     *
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function __set($key, $value)
    {
        // Then check to see if there's a query parameter
        if (!$this->isValidParameter($key)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $key
            ));
        }
        $this->$key = $value;
        return $this;
    }

    /**
     * Attempts to get an attribute by key
     *
     * @param  string  $key
     *
     * @return AbstractQuery
     */
    public function get($key)
    {
        if (method_exists($this, 'get'.self::toStudlyCase($key))) {
            return $this->{'get'.self::toStudlyCase($key)}();
        }
        return $this->$key;
    }

    /**
     * Attempts to update attribute with key/value pair
     *
     * @param  string  $key
     * @param  string  $value
     *
     * @return AbstractQuery
     */
    public function set($key, $value)
    {
        if (method_exists($this, 'set'.self::toStudlyCase($key))) {
            return $this->{'set'.self::toStudlyCase($key)}($value);
        }
        $this->$key = $value;
        return $this;
    }

    /**
     * Attempts to get an attribute by key
     *
     * @param  string  $key
     *
     * @return bool
     */
    protected function isValidParameter($key)
    {
        if (property_exists($this, $key)) {
            return true;
        }
        return false;
    }

    /**
     * Converts snakecase or underscores to camelcase
     *
     * @param string
     *
     * @return string
     */
    private static function toStudlyCase($value)
    {
        return str_replace(' ', '' , ucwords(str_replace(array('-', '_'), ' ', $value)));
    }
}
