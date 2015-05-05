<?php namespace JobBrander\Jobs\Client\Test;

use JobBrander\Jobs\Client\Job;
use JobBrander\Jobs\Client\Schema\Entity\Organization;
use JobBrander\Jobs\Client\Schema\Entity\Place;
use JobBrander\Jobs\Client\Schema\Entity\PostalAddress;

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
        $this->assertEquals($input, $this->job->getSource());
    }

    public function testSetUrl()
    {
        $input = 'http://www.example.com/job-listing-url';
        $this->job->setUrl($input);
        $this->assertEquals($input, $this->job->url);
        $this->assertEquals($input, $this->job->getUrl());
    }

    public function testSetQuery()
    {
        $input = 'engineering';
        $this->job->setQuery($input);
        $this->assertEquals($input, $this->job->query);
        $this->assertEquals($input, $this->job->getQuery());
    }

    public function testSetType()
    {
        $input = 'part-time';
        $this->job->setType($input);
        $this->assertEquals($input, $this->job->type);
        $this->assertEquals($input, $this->job->getType());
    }

    public function testSetStartDate()
    {
        $input = '10-13-1988';
        $this->job->setStartDate($input);
        $this->assertEquals($input, $this->job->startDate);
        $this->assertEquals($input, $this->job->getStartDate());
    }

    public function testSetEndDate()
    {
        $input = '10-13-2016';
        $this->job->setEndDate($input);
        $this->assertEquals($input, $this->job->endDate);
        $this->assertEquals($input, $this->job->getEndDate());
    }

    public function testSetMinimumSalary()
    {
        $input = '10000';
        $this->job->setMinimumSalary($input);
        $this->assertEquals($input, $this->job->minimumSalary);
        $this->assertEquals($input, $this->job->getMinimumSalary());
    }

    public function testSetMaximumSalary()
    {
        $input = '100000';
        $this->job->setMaximumSalary($input);
        $this->assertEquals($input, $this->job->maximumSalary);
        $this->assertEquals($input, $this->job->getMaximumSalary());
    }

    public function testSetCompany()
    {
        $company = uniqid();
        $this->job->setCompany($company);
        $this->assertEquals($company, $this->job->company);
        $this->assertEquals($company, $this->job->getCompanyName());
        $this->assertEquals($company, $this->job->getCompany());
    }

    public function testSetLocation()
    {
        $location = uniqid();
        $this->job->setLocation($location);
        $this->assertEquals($location, $this->job->location);
        $this->assertEquals($location, $this->job->getLocation());
    }

    public function testSetIndustry()
    {
        $industry = uniqid();
        $this->job->setIndustry($industry);
        $this->assertEquals($industry, $this->job->industry);
        $this->assertEquals($industry, $this->job->getIndustry());
    }

    public function testSetCodes()
    {
        $codes = [uniqid()];
        $this->job->setCodes($codes);
        $this->assertEquals($codes, $this->job->codes);
        $this->assertEquals($codes, $this->job->getCodes());
    }

    public function testAddCodes()
    {
        $code = uniqid();
        $this->job->addCodes($code);
        $this->assertContains($code, $this->job->codes);
        $this->assertContains($code, $this->job->getCodes());
    }

    public function testSetStreetAddress()
    {
        $address = uniqid();
        $this->job->setStreetAddress($address);
        $this->assertEquals($address, $this->job->getStreetAddress());
    }

    public function testSetCity()
    {
        $city = uniqid();
        $this->job->setCity($city);
        $this->assertEquals($city, $this->job->getCity());
    }

    public function testSetState()
    {
        $state = uniqid();
        $this->job->setState($state);
        $this->assertEquals($state, $this->job->getState());
    }

    public function testSetCountry()
    {
        $country = uniqid();
        $this->job->setCountry($country);
        $this->assertEquals($country, $this->job->getCountry());
    }

    public function testSetPostalCode()
    {
        $postal_code = uniqid();
        $this->job->setPostalCode($postal_code);
        $this->assertEquals($postal_code, $this->job->getPostalCode());
    }

    public function testSetTelephone()
    {
        $telephone = uniqid();
        $this->job->setTelephone($telephone);
        $this->assertEquals($telephone, $this->job->getTelephone());
    }

    public function testSetCompanyName()
    {
        $company_name = uniqid();
        $this->job->setCompanyName($company_name);
        $this->assertEquals($company_name, $this->job->getCompanyName());
    }

    public function testSetCompanyDescription()
    {
        $description = uniqid();
        $this->job->setCompanyDescription($description);
        $this->assertEquals($description, $this->job->getCompanyDescription());
    }

    public function testSetCompanyEmail()
    {
        $email = uniqid();
        $this->job->setCompanyEmail($email);
        $this->assertEquals($email, $this->job->getCompanyEmail());
    }

    public function testSetCompanyLogo()
    {
        $logo = 'http://www.example.com/'.uniqid();
        $this->job->setCompanyLogo($logo);
        $this->assertEquals($logo, $this->job->getCompanyLogo());
    }

    public function testSetCompanyUrl()
    {
        $url = 'http://www.example.com/'.uniqid();
        $this->job->setCompanyUrl($url);
        $this->assertEquals($url, $this->job->getCompanyUrl());
    }

    public function testReturnNullForUnsetProperties()
    {
        $this->assertEquals(null, $this->job->getTelephone());

        $this->assertEquals(null, $this->job->getCompanyName());
        $this->assertEquals(null, $this->job->getCompanyDescription());
        $this->assertEquals(null, $this->job->getCompanyLogo());
        $this->assertEquals(null, $this->job->getCompanyEmail());
        $this->assertEquals(null, $this->job->getCompanyUrl());

        $this->job->setJobLocation(new Place);
        $this->assertEquals(null, $this->job->getStreetAddress());
        $this->assertEquals(null, $this->job->getCity());
        $this->assertEquals(null, $this->job->getState());
        $this->assertEquals(null, $this->job->getPostalCode());
        $this->assertEquals(null, $this->job->getCountry());
    }

}
