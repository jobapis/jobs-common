<?php

/*
 * This class was automatically generated.
 */

namespace JobBrander\Jobs\Client\Schema\Entity;

/**
 * The geographic coordinates of a place or event.
 *
 * @see http://schema.org/GeoCoordinates Documentation on Schema.org
 */
class GeoCoordinates extends StructuredValue
{
    /**
     * @var string The latitude of a location. For example `37.42242`
     ([WGS 84](https://en.wikipedia.org/wiki/World_Geodetic_System)).
     */
    protected $latitude;
    /**
     * @var string The longitude of a location. For example `-122.08585`
     ([WGS 84](https://en.wikipedia.org/wiki/World_Geodetic_System)).
     */
    protected $longitude;

    /**
     * Sets latitude.
     *
     * @param string $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Gets latitude.
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets longitude.
     *
     * @param string $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Gets longitude.
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
