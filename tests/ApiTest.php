<?php
/*
 *  IndeedJobsClient.php Unit Tests
 *
 *  Uses PHPUnit to test methods and properties set in
 *  the IndeedJobsClient class.
 *
 *  It's not really even started yet...
 */

use IndeedJobs\IndeedJobsClient as JobsClient;

class ApiTest extends PHPUnit_Framework_TestCase
{
    public $client;

    public function setUp()
    {
        $this->client = new JobsClient();
    }

    public function testInstantiateClient()
    {
        //Arrange
        $config = include(__DIR__ . '/../config.php');
        $url = $this->getAttribute('baseUrl');
        $count = $this->getAttribute('count');
        $publisherId = $this->getAttribute('publisherId');
        $version = $this->getAttribute('version');
        $format = $this->getAttribute('format');

        // Assert
        // Check that class is instantiated
        $this->assertInstanceOf('IndeedJobs\IndeedJobsClient', $this->client);
        // Validate base url property
        $this->assertTrue( filter_var($url, FILTER_VALIDATE_URL) !== FALSE );
        // Default count set to 10
        $this->assertEquals(10, $count);
        // Publisher ID equal to id in config file
        $this->assertEquals($config['publisher_id'], $publisherId);
        // Always use version 2 for Indeed
        $this->assertEquals(2, $version);
        // We like json
        $this->assertEquals('json', $format);
    }

    public function testSetFormat()
    {
        // Arrange
        $input = 'json';
        // Act
        $this->client->setFormat($input);
        // Assert
        $this->assertEquals($input, $this->getAttribute('format'));
    }

    public function testSetQuery()
    {
        // Arrange
        $input = 'test';
        // Act
        $this->client->setQuery($input);
        // Assert
        $this->assertEquals($input, $this->getAttribute('query'));
    }

    public function testSetCity()
    {
        // Arrange
        $input = 'Chicago';
        // Act
        $this->client->setCity($input);
        // Assert
        $this->assertEquals($input, $this->getAttribute('city'));
    }

    public function testSetState()
    {
        // Arrange
        $input = 'IL';
        // Act
        $this->client->setState($input);
        // Assert
        $this->assertEquals($input, $this->getAttribute('state'));
    }

    public function testSetCount()
    {
        // Arrange
        $input = 12;
        // Act
        $this->client->setCount($input);
        // Assert
        $this->assertEquals($input, $this->getAttribute('count'));
    }

    public function testSetPage()
    {
        // Arrange
        $input = 2;
        // Act
        $this->client->setPage($input);
        // Assert
        $this->assertEquals($input, $this->getAttribute('page'));
    }

    private function getAttribute($attributeName)
    {
        return PHPUnit_Framework_Assert::readAttribute($this->client, $attributeName);
    }
}
