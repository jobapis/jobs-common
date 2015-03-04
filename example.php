<?php
// To view this page, run "php -S localhost:8080"
if (!isWebRequest()) {
  echo "To view this page on a webserver using PHP 5.4 or above run: \n\t
    php -S localhost:8080\n";
  exit();
}

require_once __DIR__ . '/vendor/autoload.php';

use Jobs\Job;

$job = new Job();

echo "<pre>"; print_r($job); echo "</pre>";
