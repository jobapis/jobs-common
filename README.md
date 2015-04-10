# Jobs Client - Common #

[![Latest Version](https://img.shields.io/github/release/jobbrander/jobs-common.svg?style=flat-square)](https://github.com/jobbrander/jobs-common/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jobbrander/jobs-common/master.svg?style=flat-square&1)](https://travis-ci.org/jobbrander/jobs-common)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jobbrander/jobs-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobbrander/jobs-common/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobbrander/jobs-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobbrander/jobs-common)
[![Total Downloads](https://img.shields.io/packagist/dt/jobbrander/jobs-common.svg?style=flat-square)](https://packagist.org/packages/jobbrander/jobs-common)

This library includes interfaces and objects for standardizing responses from API clients. Each client that uses this is expected to return a collection of jobs that it generates with its own transformer.

## Requirements ##
* [PHP 5.4.0 or higher](http://www.php.net/)
* [PHP JSON extension](http://php.net/manual/en/book.json.php)

## Getting Started ##
* Run `composer update`
* Check out the example.php file to see an example of the api library at work.

#### OR ####

* Install from [Packagist](https://packagist.org/packages/jobbrander/jobs-common)

## Note ##
This project is still in progress.

## Usage

```php
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
```
