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
     * Create new query from parameters and defaults
     *
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        $parameters = array_flip(array_merge($this->defaultAttributes(), $parameters));

        array_walk($parameters, [$this, 'set']);
    }

    /**
     * Get listings path
     *
     * @return  string
     */
    // abstract public function getListingsPath();

    /**
     * Attempts to get an attribute by key
     *
     * @param  string  $key
     *
     * @return AbstractQuery
     */
    public function get($key)
    {
        if (!$this->isValidParameter($key)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $key
            ));
        }
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
        // Then check to see if there's a query parameter
        if (!$this->isValidParameter($key)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $key
            ));
        }
        if (method_exists($this, 'set'.self::toStudlyCase($key))) {
            return $this->{'set'.self::toStudlyCase($key)}($value);
        }
        $this->$key = $value;
        return $this;
    }

    /**
     * Default parameters
     *
     * @var array
     */
    protected function defaultAttributes()
    {
        return [];
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
     * Required parameters
     *
     * @var array
     */
    protected function requiredAttributes()
    {
        return [];
    }

    /**
     * Converts snakecase or underscores to camelcase
     *
     * @param string
     *
     * @return string
     */
    protected static function toStudlyCase($value)
    {
        return str_replace(' ', '' , ucwords(str_replace(array('-', '_'), ' ', $value)));
    }
}
