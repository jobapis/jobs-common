<?php namespace Jobs\Interfaces;

interface JobInterface
{
    /**
    * Sets external ID for this job given by API result
    *
    * @param string $id
    */
    public function setId($id = NULL);

    /**
    * Sets Title for this job given by API result
    *
    * @param string $title
    */
    public function setTitle($title = NULL);

    /**
    * Sets Description for this job given by API result
    *
    * @param string $description
    */
    public function setDescription($description = NULL);

    /**
    * Sets Source of this job (website that originated the listing)
    *
    * @param string $source
    */
    public function setSource($source = NULL);

    /**
    * Sets original Url of this job
    *
    * @param string $url Valid url string
    */
    public function setUrl($url = NULL);

    /**
    * Sets original Query used to find this job (if any)
    *
    * @param string $query
    */
    public function setQuery($query = NULL);

    /**
    * Sets type of job
    *
    * @param string $type Job type (part-time, full-time, etc.)
    */
    public function setType($type = NULL); // Job type

    /**
    * Sets Companies for this job given by API result
    *
    * @param array $companies Array of companies (id, name, url, image_url, etc.)
    */
    public function setCompanies($companies = []);

    /**
    * Sets Locations for this job given by API result
    *
    * @param array $locations Array of locations (city, state, country, postal_code, etc.)
    */
    public function setLocations($locations = []);

    /**
    * Sets Industries for this job given by API result
    *
    * @param array $industries Array of industries (id, name, description, etc.)
    */
    public function setIndustries($industries = []);

    /**
    * Sets dates for this job posting
    *
    * @param array $dates Array of dates (posting date, ending date)
    */
    public function setDates($dates = []);

    /**
    * Sets salary/payment details for this job posting
    *
    * @param array $salaries Array of salaries or pay rates for position (minimum, maximum, salary, etc.)
    */
    public function setSalaries($salaries = []);

    /**
    * Sets special codes given by API results
    *
    * @param array $codes Array of codes
    */
    public function setCodes($codes = []);
}
