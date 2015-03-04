<?php namespace Jobs;

interface JobsClientInterface
{
    /**
    * Sets query keyword/string for an api call
    *
    * @param string $query
    */
    public function setQuery($query = '');

    /**
    * Sets state for an api search
    *
    * @param string $state
    */
    public function setState($state = '');

    /**
    * Sets city for an api search
    *
    * @param string $city
    */
    public function setCity($city = '');

    /**
    * Sets count for number of results to return
    *
    * @param string $count
    */
    public function setCount($count = 10);

    /**
    * Sets page number for results
    *
    * @param string $page
    */
    public function setPage($page = 1);

    /**
    * Makes the api call and returns a collection of job objects
    */
    public function getJobs();
}
