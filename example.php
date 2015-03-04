<?php
// To view this page, run "php -S localhost:8080"
if (!isset($_SERVER['HTTP_USER_AGENT'])) {
  echo "To view this page on a webserver using PHP 5.4 or above run: \n\t
    php -S localhost:8080\n";
  exit();
}

require_once __DIR__ . '/vendor/autoload.php';

use Jobs\Collections\JobsCollection;
use Jobs\Job;

// Instantiate a new JobsCollection
$jobs = new JobsCollection(['query' => 'newQuery']);

// Instantiate a new Job
$job = new Job([
    'id' => '123kdk345',
    'url' => 'http://www.example.com/testUrl',
]);

// Add the Job to the Collection
$jobs->add($job);

// Add an error to the collection
$jobs->addError("New Error on the Collection.");

echo "<pre>"; print_r($jobs); echo "</pre>";
