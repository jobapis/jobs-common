<?php namespace Jobs\Collections;

use Jobs\Job;

class JobsCollection extends Collection
{
    public $query;
    public $totalResults;
    public $count;
    public $page;
    public $error;
    private $jobs = [];

    public function addJob($job, $key = null)
    {
        if ($key == null) {
            $this->jobs[] = $job;
        } else {
            if (isset($this->jobs[$key])) {
                return $this->setError("Invalid key $key.");
            } else {
                $this->jobs[$key] = $job;
            }
        }
        return $this;
    }

    public function deleteJob($key)
    {
        if (isset($this->jobs[$key])) {
            unset($this->jobs[$key]);
        } else {
            return $this->setError("Invalid key $key.");
        }
        return $this;
    }

    public function getJob($key)
    {
        if (isset($this->jobs[$key])) {
            return $this->jobs[$key];
        } else {
            return $this->setError("Invalid key $key.");
        }
        return $this;
    }

    public function setError($message = NULL)
    {
        $this->error = $message;
        return $this;
    }
}
