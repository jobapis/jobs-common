<?php namespace Jobs;

interface JobsTransformerInterface
{
    /**
    * Returns the standardized job object
    */
    public function createJobObject();

}
