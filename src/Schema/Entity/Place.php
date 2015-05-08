<?php

/*
 * This class was automatically generated.
 */

namespace JobBrander\Jobs\Client\Schema\Entity;

/**
 * Entities that have a somewhat fixed, physical extension.
 *
 * @see http://schema.org/Place Documentation on Schema.org
 */
class Place extends Thing
{
    /**
     * @var PostalAddress Physical address of the item.
     */
    protected $address;
    /**
     * @var string The telephone number.
     */
    protected $telephone;

    /**
     * Sets address.
     *
     * @param PostalAddress $address
     *
     * @return $this
     */
    public function setAddress(PostalAddress $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets address.
     *
     * @return PostalAddress
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets telephone.
     *
     * @param string $telephone
     *
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Gets telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}
