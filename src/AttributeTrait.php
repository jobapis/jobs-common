<?php namespace JobBrander\Jobs;

trait AttributeTrait
{
    /**
     * [__get description]
     *
     * @param  [type]  [description]
     *
     * @return [type]  [description]
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
     * [__set description]
     *
     * @param [type]  [description]
     * @param [type]  [description]
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
     * [__isset description]
     *
     * @param  [type]   [description]
     *
     * @return boolean  [description]
     */
    public function __isset($name)
    {
        return (property_exists($this, $name));
    }

    /**
     * [__call description]
     *
     * @param  [type]  [description]
     * @param  [type]  [description]
     *
     * @return [type]  [description]
     */
    public function __call($method, $parameters = [])
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
     * [getAttributeFromGetSetMethod description]
     *
     * @param  [type]  [description]
     *
     * @return [type]  [description]
     */
    private function getAttributeFromGetSetMethod($method)
    {
        return lcfirst(preg_replace('/[s|g]et/', '', $method));
    }

    /**
     * [isGetterMethod description]
     *
     * @param  [type]   [description]
     *
     * @return boolean  [description]
     */
    private function isGetterMethod($method)
    {
        return substr($method, 0, 3) === "get";
    }

    /**
     * [isSetterMethod description]
     *
     * @param  [type]   [description]
     *
     * @return boolean  [description]
     */
    private function isSetterMethod($method)
    {
        return substr($method, 0, 3) === "set";
    }
}
