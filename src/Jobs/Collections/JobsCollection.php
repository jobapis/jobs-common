<?php namespace Jobs\Collections;

use Jobs\Job;

class JobsCollection extends Collection
{
    protected $attributes = [];

    public function __construct($attributes = [])
    {
        $this->setAttributes($attributes);
    }

    public function setAttributes($attributes = [])
    {
        if ($attributes && is_array($attributes)) {
            foreach ($attributes as $name => $value) {
                $this->attributes[$name] = $value;
            }
        }
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

}
