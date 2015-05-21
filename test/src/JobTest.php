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

        $this->assertEquals($sourceId, $job->getSourceId());
        $this->assertEquals($title, $job->getTitle());
    }

    public function testItCanCheckIfExistingPropertyIsset()
    {
        $key = 'sourceId';
        $value = uniqid();

        $this->job->{'set'.ucfirst($key)}($value);
        $result = isset($this->job->{$key});

        $this->assertTrue($result);
    }

    public function testItCanSetAndGetExistingProperty()
    {
        $key = 'sourceId';
        $value = uniqid();

        $this->job->{'set'.ucfirst($key)}($value);
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
        $this->assertEquals($input, $this->job->getTitle());
    }

    public function testSetJavascriptAction()
    {
        $input = 'onclick';
        $this->job->setJavascriptAction($input);
        $this->assertEquals($input, $this->job->javascriptAction);
        $this->assertEquals($input, $this->job->getJavascriptAction());
    }

    public function testSetJavascriptFunction()
    {
        $input = 'doJob(' . uniqid() . ')';
        $this->job->setJavascriptFunction($input);
        $this->assertEquals($input, $this->job->javascriptFunction);
        $this->assertEquals($input, $this->job->getJavascriptFunction());
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
        $this->assertEquals($input, $this->job->getBaseSalary());
    }

    public function testSetMaximumSalary()
    {
        $input = '100000';
        $this->job->setMaximumSalary($input);
        $this->assertEquals($input, $this->job->maximumSalary);
        $this->assertEquals($input, $this->job->getMaximumSalary());
    }

    public function testSetBaseSalaryWithOnlyNumbers()
    {
        $input = '100000';
        $result = 100000.00;
        $this->job->setBaseSalary($input);
        $this->assertEquals($result, $this->job->baseSalary);
        $this->assertEquals($result, $this->job->getBaseSalary());
    }

    public function testSetBaseSalaryWithOnlyNumbersAndDecimal()
    {
        $input = '100000.00';
        $result = 100000.00;
        $this->job->setBaseSalary($input);
        $this->assertEquals($result, $this->job->baseSalary);
        $this->assertEquals($result, $this->job->getBaseSalary());
    }

    public function testSetBaseSalaryWithOnlyNumbersAndMisplacedDecimal()
    {
        $input = '100.00000';
        $result = 100.00;
        $this->job->setBaseSalary($input);
        $this->assertEquals($result, $this->job->baseSalary);
        $this->assertEquals($result, $this->job->getBaseSalary());
    }

    public function testSetBaseSalaryWithCommas()
    {
        $input = '100,000';
        $result = 100000.00;
        $this->job->setBaseSalary($input);
        $this->assertEquals($result, $this->job->baseSalary);
        $this->assertEquals($result, $this->job->getBaseSalary());
    }

    public function testSetBaseSalaryWithCurrencySymbol()
    {
        $input = '$100000';
        $result = 100000.00;
        $this->job->setBaseSalary($input);
        $this->assertEquals($result, $this->job->baseSalary);
        $this->assertEquals($result, $this->job->getBaseSalary());
    }

    public function testSetBaseSalaryWithoutNumbers()
    {
        $input = 'i like turtles.';
        $this->job->setBaseSalary($input);
        $this->assertNull($this->job->baseSalary);
        $this->assertNull($this->job->getBaseSalary());
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

    public function testSetStreetAddress()
    {
        $address = uniqid();
        $this->job->setStreetAddress($address);
        $this->assertEquals($address, $this->job->getStreetAddress());
        $this->assertEquals($address, $this->job->getHiringOrganization()->getAddress()->getStreetAddress());
        $this->assertNull($this->job->getHiringOrganization()->getAddress()->getPostOfficeBoxNumber());
        $this->assertEquals($address, $this->job->getJobLocation()->getAddress()->getStreetAddress());
        $this->assertNull($this->job->getJobLocation()->getAddress()->getPostOfficeBoxNumber());
    }

    public function testSetStreetAddressAddsPOBox()
    {
        $address = uniqid().'PO Box';
        $this->job->setStreetAddress($address);
        $this->assertEquals($address, $this->job->getStreetAddress());
        $this->assertEquals($address, $this->job->getHiringOrganization()->getAddress()->getStreetAddress());
        $this->assertEquals($address, $this->job->getHiringOrganization()->getAddress()->getPostOfficeBoxNumber());
        $this->assertEquals($address, $this->job->getJobLocation()->getAddress()->getStreetAddress());
        $this->assertEquals($address, $this->job->getJobLocation()->getAddress()->getPostOfficeBoxNumber());
    }

    public function testSetCity()
    {
        $city = uniqid();
        $this->job->setCity($city);
        $this->assertEquals($city, $this->job->getCity());
        $this->assertEquals($city, $this->job->getHiringOrganization()->getAddress()->getAddressLocality());
        $this->assertEquals($city, $this->job->getJobLocation()->getAddress()->getAddressLocality());
    }

    public function testSetState()
    {
        $state = uniqid();
        $this->job->setState($state);
        $this->assertEquals($state, $this->job->getState());
        $this->assertEquals($state, $this->job->getHiringOrganization()->getAddress()->getAddressRegion());
        $this->assertEquals($state, $this->job->getJobLocation()->getAddress()->getAddressRegion());
    }

    public function testSetCountry()
    {
        $country = uniqid();
        $this->job->setCountry($country);
        $this->assertEquals($country, $this->job->getCountry());
        $this->assertEquals($country, $this->job->getHiringOrganization()->getAddress()->getAddressCountry());
        $this->assertEquals($country, $this->job->getJobLocation()->getAddress()->getAddressCountry());
    }

    public function testSetPostalCode()
    {
        $postal_code = uniqid();
        $this->job->setPostalCode($postal_code);
        $this->assertEquals($postal_code, $this->job->getPostalCode());
        $this->assertEquals($postal_code, $this->job->getHiringOrganization()->getAddress()->getPostalCode());
        $this->assertEquals($postal_code, $this->job->getJobLocation()->getAddress()->getPostalCode());
    }

    public function testSetTelephone()
    {
        $telephone = uniqid();
        $this->job->setTelephone($telephone);
        $this->assertEquals($telephone, $this->job->getTelephone());
        $this->assertEquals($telephone, $this->job->getHiringOrganization()->getTelephone());
        $this->assertEquals($telephone, $this->job->getJobLocation()->getTelephone());
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

    public function testSetDatePostedWithValidDateTime()
    {
        $date = new \DateTime;
        $this->job->setDatePosted($date);
        $this->assertEquals($date, $this->job->getDatePosted());
    }

    public function testSetDatePostedAsStringWithValidDateTimeString()
    {
        $date = '2015-05-01';
        $this->job->setDatePostedAsString($date);
    }

    /**
     * @expectedException JobBrander\Jobs\Client\Exceptions\InvalidFormatException
     */
    public function testSetDatePostedAsStringWithoutValidDateTimeString()
    {
        $date = 'i like turtles';
        $this->job->setDatePostedAsString($date);
    }

    public function testSetOccupationalCategoryWithCodeAndTitle()
    {
        $code = rand(1, 20) . '-' . rand(1000, 9999);
        $title = uniqid();
        $this->job->setOccupationalCategoryWithCodeAndTitle($code, $title);
        $this->assertEquals($code . ' - ' . $title, $this->job->getOccupationalCategory());
    }

    public function testBenignTextValues()
    {
        $attributes = [
            'alternateName', 'jobBenefits', 'educationRequirements', 'employmentType',
            'experienceRequirements', 'incentiveCompensation', 'occupationalCategory',
            'qualifications', 'responsibilities', 'salaryCurrency', 'skills',
            'specialCommitments', 'title', 'workHours'
        ];

        array_walk($attributes, function ($attribute) {
            $value = uniqid();
            $this->job->{'set'.ucfirst($attribute)}($value);
            $this->assertEquals($value, $this->job->{'get'.ucfirst($attribute)}());
        });
    }

    public function testReturnNullForUnsetProperties()
    {
        $this->assertNull($this->job->getTelephone());

        $this->assertNull($this->job->getCompanyName());
        $this->assertNull($this->job->getCompanyDescription());
        $this->assertNull($this->job->getCompanyLogo());
        $this->assertNull($this->job->getCompanyEmail());
        $this->assertNull($this->job->getCompanyUrl());

        $this->job->setJobLocation(new Place);
        $this->assertNull($this->job->getStreetAddress());
        $this->assertNull($this->job->getCity());
        $this->assertNull($this->job->getState());
        $this->assertNull($this->job->getPostalCode());
        $this->assertNull($this->job->getCountry());
    }

    public function testItCanBeSerializedAsJson()
    {
        $value = uniqid();
        $date = new \DateTime();
        $poBox = 'PO Box '.$value;

        $this->job->setAlternateName($value);
        $this->job->setBaseSalary($value);
        $this->job->setCity($value);
        $this->job->setCompany($value);
        $this->job->setCompanyDescription($value);
        $this->job->setCompanyEmail($value);
        $this->job->setCompanyLogo($value);
        $this->job->setCompanyName($value);
        $this->job->setCompanyUrl($value);
        $this->job->setCountry($value);
        $this->job->setDatePosted($date);
        $this->job->setDescription($value);
        $this->job->setEducationRequirements($value);
        $this->job->setEmploymentType($value);
        $this->job->setEndDate($value);
        $this->job->setExperienceRequirements($value);
        $this->job->setIncentiveCompensation($value);
        $this->job->setIndustry($value);
        $this->job->setJavascriptAction($value);
        $this->job->setJavascriptFunction($value);
        $this->job->setJobBenefits($value);
        $this->job->setLocation($value);
        $this->job->setMaximumSalary($value);
        $this->job->setMinimumSalary($value);
        $this->job->setName($value);
        $this->job->setOccupationalCategory($value);
        $this->job->setOccupationalCategoryWithCodeAndTitle($value, $value);
        $this->job->setPostalCode($value);
        $this->job->setQualifications($value);
        $this->job->setQuery($value);
        $this->job->setResponsibilities($value);
        $this->job->setSalaryCurrency($value);
        $this->job->setSkills($value);
        $this->job->setSource($value);
        $this->job->setSourceId($value);
        $this->job->setSpecialCommitments($value);
        $this->job->setStartDate($value);
        $this->job->setState($value);
        $this->job->setStreetAddress($poBox);
        $this->job->setTelephone($value);
        $this->job->setTitle($value);
        $this->job->setType($value);
        $this->job->setUrl($value);
        $this->job->setWorkHours($value);

        $jsonEncode = json_encode($this->job);
        $toJson = $this->job->toJson();

        $this->assertEquals($jsonEncode, $toJson);
    }

    public function testItSerializesCompanyData()
    {
        $name = uniqid();
        $description = uniqid();
        $email = uniqid();
        $logo = uniqid();
        $url = uniqid();

        $this->job->setCompany($name);
        $this->job->setCompanyDescription($description);
        $this->job->setCompanyEmail($email);
        $this->job->setCompanyLogo($logo);
        $this->job->setCompanyName($name);
        $this->job->setCompanyUrl($url);

        $toJson = $this->job->toJson();
        $toObj = json_decode($toJson);

        $this->assertEquals($name, $toObj->company);
        $this->assertEquals($description, $toObj->hiringOrganization->description);
        $this->assertEquals($email, $toObj->hiringOrganization->email);
        $this->assertEquals($logo, $toObj->hiringOrganization->logo);
        $this->assertEquals($name, $toObj->hiringOrganization->name);
        $this->assertEquals($url, $toObj->hiringOrganization->url);
    }

    public function testItSerializesLocationData()
    {
        $city = uniqid();
        $country = uniqid();
        $location = uniqid();
        $postal_code = uniqid();
        $state = uniqid();
        $address = uniqid();
        $telephone = uniqid();

        $this->job->setCity($city);
        $this->job->setCountry($country);
        $this->job->setLocation($location);
        $this->job->setPostalCode($postal_code);
        $this->job->setState($state);
        $this->job->setStreetAddress($address);
        $this->job->setTelephone($telephone);

        $toJson = $this->job->toJson();
        $toObj = json_decode($toJson);

        $this->assertEquals($location, $toObj->location);
        $this->assertEquals($city, $toObj->jobLocation->address->addressLocality);
        $this->assertEquals($country, $toObj->jobLocation->address->addressCountry);
        $this->assertEquals($postal_code, $toObj->jobLocation->address->postalCode);
        $this->assertEquals($state, $toObj->jobLocation->address->addressRegion);
        $this->assertEquals($address, $toObj->jobLocation->address->streetAddress);
        $this->assertEquals($telephone, $toObj->jobLocation->telephone);
    }

    public function testItSerializesJobData()
    {
        $alt_name = uniqid();
        $base_salary = rand(10, 1000);
        $date = new \DateTime();
        $description = uniqid();
        $education = uniqid();
        $employment_type = uniqid();
        $experience = uniqid();
        $incentive_comp = uniqid();
        $industry = uniqid();
        $js_action = uniqid();
        $js_function = uniqid();
        $job_benefits = uniqid();
        $max_salary = uniqid();
        $name = uniqid();
        $occupational_cat = uniqid();
        $qualifications = uniqid();
        $query = uniqid();
        $responsibilities = uniqid();
        $salary_currency = uniqid();
        $skills = uniqid();
        $source = uniqid();
        $sourceId = uniqid();
        $special = uniqid();
        $title = uniqid();
        $type = uniqid();
        $url = uniqid();
        $work_hours = uniqid();

        $this->job->setAlternateName($alt_name);
        $this->job->setBaseSalary($base_salary);
        $this->job->setDatePosted($date);
        $this->job->setDescription($description);
        $this->job->setEducationRequirements($education);
        $this->job->setEmploymentType($employment_type);
        $this->job->setEndDate($date);
        $this->job->setExperienceRequirements($experience);
        $this->job->setIncentiveCompensation($incentive_comp);
        $this->job->setIndustry($industry);
        $this->job->setJavascriptAction($js_action);
        $this->job->setJavascriptFunction($js_function);
        $this->job->setJobBenefits($job_benefits);
        $this->job->setMaximumSalary($max_salary);
        $this->job->setMinimumSalary($base_salary);
        $this->job->setName($name);
        $this->job->setOccupationalCategory($occupational_cat);
        $this->job->setQualifications($qualifications);
        $this->job->setQuery($query);
        $this->job->setResponsibilities($responsibilities);
        $this->job->setSalaryCurrency($salary_currency);
        $this->job->setSkills($skills);
        $this->job->setSource($source);
        $this->job->setSourceId($sourceId);
        $this->job->setSpecialCommitments($special);
        $this->job->setStartDate($date);
        $this->job->setTitle($title);
        $this->job->setType($type);
        $this->job->setUrl($url);
        $this->job->setWorkHours($work_hours);

        $toJson = $this->job->toJson();
        $toObj = json_decode($toJson);

        $this->assertEquals($alt_name, $toObj->alternateName);
        $this->assertEquals($base_salary, $toObj->baseSalary);
        $this->assertEquals($date->format('Y-m-d'), $toObj->datePosted);
        $this->assertEquals($description, $toObj->description);
        $this->assertEquals($education, $toObj->educationRequirements);
        $this->assertEquals($employment_type, $toObj->employmentType);
        $this->assertEquals($date->format('Y-m-d'), $toObj->endDate);
        $this->assertEquals($experience, $toObj->experienceRequirements);
        $this->assertEquals($incentive_comp, $toObj->incentiveCompensation);
        $this->assertEquals($industry, $toObj->industry);
        $this->assertEquals($js_action, $toObj->javascriptAction);
        $this->assertEquals($js_function, $toObj->javascriptFunction);
        $this->assertEquals($job_benefits, $toObj->jobBenefits);
        $this->assertEquals($max_salary, $toObj->maximumSalary);
        $this->assertEquals($base_salary, $toObj->minimumSalary);
        $this->assertEquals($name, $toObj->name);
        $this->assertEquals($occupational_cat, $toObj->occupationalCategory);
        $this->assertEquals($qualifications, $toObj->qualifications);
        $this->assertEquals($query, $toObj->query);
        $this->assertEquals($responsibilities, $toObj->responsibilities);
        $this->assertEquals($salary_currency, $toObj->salaryCurrency);
        $this->assertEquals($skills, $toObj->skills);
        $this->assertEquals($source, $toObj->source);
        $this->assertEquals($sourceId, $toObj->sourceId);
        $this->assertEquals($special, $toObj->specialCommitments);
        $this->assertEquals($date->format('Y-m-d'), $toObj->startDate);
        $this->assertEquals($title, $toObj->title);
        $this->assertEquals($type, $toObj->type);
        $this->assertEquals($url, $toObj->url);
        $this->assertEquals($work_hours, $toObj->workHours);
    }
}
