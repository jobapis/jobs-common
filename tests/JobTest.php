<?php
/**
 *  Uses PHPUnit to test methods and properties set in
 *  the Job class.
 */

use Jobs\Job;

class JobTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->job = new Job();
    }

    public function testInstantiateJobWithAttributes()
    {
        $id = uniqid();
        $title = "test title";
        $job = new Job([
            'id' => $id,
            'title' => $title
        ]);

        $this->assertEquals($id, $job->id);
        $this->assertEquals($title, $job->title);
    }

    public function testSetId()
    {
        // Arrange
        $id = uniqid();
        // Act
        $this->job->setId($id);
        // Assert
        $this->assertEquals($id, $this->job->id);
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
        //
    }

}
