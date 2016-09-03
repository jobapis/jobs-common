<?php

/*
 * This class was automatically generated.
 */

namespace JobApis\Jobs\Client\Schema\Entity;

/**
 * The most generic type of item.
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 */
abstract class Thing
{
    /**
     * @var string An alias for the item.
     */
    protected $alternateName;
    /**
     * @var string A short description of the item.
     */
    protected $description;
    /**
     * @var string The name of the item.
     */
    protected $name;
    /**
     * @var string URL of the item.
     */
    protected $url;

    /**
     * Sets alternateName.
     *
     * @param string $alternateName
     *
     * @return $this
     */
    public function setAlternateName($alternateName)
    {
        $this->alternateName = $alternateName;

        return $this;
    }

    /**
     * Gets alternateName.
     *
     * @return string
     */
    public function getAlternateName()
    {
        return $this->alternateName;
    }

    /**
     * Sets description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets url.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Gets url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns array representation of Thing.
     *
     * @return array
     */
    public function toArray()
    {
        $array = get_object_vars($this);
        array_walk($array, function ($value, $key) use (&$array) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $array[$key] = $value->toArray();
            }
        });
        return $array;
    }
}
