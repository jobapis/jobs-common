<?php namespace JobBrander\Jobs\Client\Test;

use JobBrander\Jobs\Client\Job;

/**
 *  Uses PHPUnit to test methods and properties set in
 *  the Job class.
 */
class JobTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->job = new Job();
    }

    public function testGetSourceId()
    {
        $sourceId = uniqid();

        $result = $this->job->setSourceId($sourceId)->getSourceId();

        $this->assertEquals($sourceId, $result);
    }

    public function testInstantiateJobWithAttributes()
    {
        $sourceId = uniqid();
        $title = "test title";
        $job = new Job([
            'sourceId' => $sourceId,
            'title' => $title
        ]);

        $this->assertEquals($sourceId, $job->sourceId);
        $this->assertEquals($title, $job->title);
    }

    public function testItCanCheckIfExistingPropertyIsset()
    {
        $key = 'sourceId';
        $value = uniqid();

        $this->job->{$key} = $value;
        $result = isset($this->job->{$key});

        $this->assertTrue($result);
    }

    public function testItCanSetAndGetExistingProperty()
    {
        $key = 'sourceId';
        $value = uniqid();

        $this->job->{$key} = $value;
        $result = $this->job->{$key};

        $this->assertEquals($value, $result);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testItCanNotHandleNonImplementedMethods()
    {
        $method = uniqid();

        $this->job->{$method}();
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testItCanNotGetNonExistentProperty()
    {
        $key = uniqid();

        $this->job->{$key};
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testItCanNotSetNonExistentProperty()
    {
        $key = uniqid();
        $value = $key;

        $this->job->{$key} = $value;
    }

    public function testSetSourceId()
    {
        // Arrange
        $sourceId = uniqid();
        // Act
        $this->job->setSourceId($sourceId);
        // Assert
        $this->assertEquals($sourceId, $this->job->sourceId);
    }

    public function testSetTitle()
    {
        $input = 'test title';
        $this->job->setTitle($input);
        $this->assertEquals($input, $this->job->title);
    }

    public function testSetDescription()
    {
        $input = 'Test job listing description';
        $this->job->setDescription($input);
        $this->assertEquals($input, $this->job->description);
    }

    public function testSetSource()
    {
        $input = 'SourceName';
        $this->job->setSource($input);
        $this->assertEquals($input, $this->job->source);
    }

    public function testSetUrl()
    {
        $input = 'http://www.example.com/job-listing-url';
        $this->job->setUrl($input);
        $this->assertEquals($input, $this->job->url);
    }

    public function testSetQuery()
    {
        $input = 'engineering';
        $this->job->setQuery($input);
        $this->assertEquals($input, $this->job->query);
    }

    public function testSetType()
    {
        $input = 'part-time';
        $this->job->setType($input);
        $this->assertEquals($input, $this->job->type);
    }

    public function testSetCompanies()
    {
        $companies = [uniqid()];
        $this->job->setCompanies($companies);
        $this->assertEquals($companies, $this->job->companies);
    }

    public function testAddCompanies()
    {
        $company = uniqid();
        $this->job->addCompanies($company);
        $this->assertContains($company, $this->job->companies);
    }

}
