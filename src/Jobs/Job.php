<?php namespace Jobs;

use Jobs\Interfaces\JobsInterface;

class Job implements JobInterface
{

    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            //
        }
    }

    public function setId($id = NULL)
    {

    }

    public function setTitle($title = NULL)
    {

    }

    public function setDescription($description = NULL)
    {

    }

    public function setSource($source = NULL)
    {

    }

    public function setUrl($url = NULL)
    {

    }

    public function setQuery($query = NULL)
    {

    }

    public function setType($type = NULL)
    {

    }

    public function setCompanies($companies = [])
    {

    }

    public function setLocations($locations = [])
    {

    }

    public function setIndustries($industries = [])
    {

    }

    public function setDates($dates = [])
    {

    }

    public function setSalaries($salaries = [])
    {

    }

    public function setCodes($codes = [])
    {

    }

}
