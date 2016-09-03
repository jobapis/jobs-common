<?php namespace JobApis\Jobs\Client;

trait AttributeTrait
{
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
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if ($this->isSetterMethod($method)) {
            return $this->setAttributeValueFromMethod($method, $parameters);
        } elseif ($this->isGetterMethod($method)) {
            return $this->getAttributeValueFromMethod($method);
        }

        throw new \BadMethodCallException(sprintf(
            '%s does not contain a method by the name of "%s"',
            __CLASS__,
            $method
        ));
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
        return lcfirst(preg_replace('/[s|g]et|add/', '', $method));
    }

    /**
     * Gets an attribute based on arbitrary method name
     *
     * @param string $method
     *
     * @return mixed
     */
    private function getAttributeValueFromMethod($method)
    {
        $attribute = $this->getAttributeFromGetSetMethod($method);
        return $this->{$attribute};
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

    /**
     * Sets an attribute based on arbitrary method name and parameters
     *
     * @param string $method
     * @param array $parameters
     *
     * @return object
     */
    private function setAttributeValueFromMethod($method, $parameters)
    {
        $attribute = $this->getAttributeFromGetSetMethod($method);
        $value = count($parameters) ? $parameters[0] : null;
        $this->{$attribute} = $value;
        return $this;
    }
}
