<?php namespace Jobs\Interfaces;

interface JobsTransformerInterface
{
    /**
    * Returns the standardized job object
    */
    public function createJobObject($input);

}
