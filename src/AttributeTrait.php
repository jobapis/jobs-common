<?php namespace JobBrander\Jobs;

trait AttributeTrait
{
    /**
     * Magic method to get protected property, if exists
     *
     * @param  string $name
     *
     * @return mixed
     * @throws OutOfRangeException
     */
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $name
            ));
        }

        return $this->{$name};
    }

    /**
     * Magic method to set protected property, if exists
     *
     * @param  string $property
     * @param  mixed $value
     *
     * @return mixed
     * @throws OutOfRangeException
     */
    public function __set($property, $value)
    {
        if (!property_exists($this, $property)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $property
            ));
        }
        $this->$property = $value;
    }

    /**
     * Magic method to check if property is set
     *
     * @param  string $name
     *
     * @return boolean
     */
    public function __isset($name)
    {
        return (property_exists($this, $name));
    }

    /**
     * Magic method to handle get and set methods for properties
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        $attribute = $this->getAttributeFromGetSetMethod($method);
        $value = count($parameters) ? $parameters[0] : null;

        if ($this->isSetterMethod($method)) {
            $this->{$attribute} = $value;

            return $this;
        } elseif ($this->isGetterMethod($method)) {
            return $this->{$attribute};
        }

        throw new \BadMethodCallException;
    }

    /**
     * Get property name from get and set method names
     *
     * @param  string $method
     *
     * @return string
     */
    private function getAttributeFromGetSetMethod($method)
    {
        return lcfirst(preg_replace('/[s|g]et/', '', $method));
    }

    /**
     * Checks if given method name is a get method
     *
     * @param  string $method
     *
     * @return boolean
     */
    private function isGetterMethod($method)
    {
        return substr($method, 0, 3) === "get";
    }

    /**
     * Checks if given method name is a set method
     *
     * @param  string $method
     *
     * @return boolean
     */
    private function isSetterMethod($method)
    {
        return substr($method, 0, 3) === "set";
    }
}
