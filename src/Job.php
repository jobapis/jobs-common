<?php namespace JobApis\Jobs\Client;

use \DateTime;
use \JsonSerializable;
use JobApis\Jobs\Client\Exceptions\InvalidFormatException;
use JobApis\Jobs\Client\Schema\Entity\GeoCoordinates;
use JobApis\Jobs\Client\Schema\Entity\JobPosting;
use JobApis\Jobs\Client\Schema\Entity\Organization;
use JobApis\Jobs\Client\Schema\Entity\Place;
use JobApis\Jobs\Client\Schema\Entity\PostalAddress;

class Job extends JobPosting implements JsonSerializable
{
    use AttributeTrait, JsonLinkedDataTrait;

    const SERIALIZE_STANDARD = "serialize-standard";

    const SERIALIZE_STANDARD_LD = "serialize-standard-ld";

    const SERIALIZE_CORE_SCHEMA_LD = "serialize-core-schema-ld";

    /**
     * Job Company
     *
     * @var string
     */
    protected $company;

    /**
     * Job End Date
     *
     * @var string
     */
    protected $endDate;

    /**
     * Job Industry
     *
     * @var string
     */
    protected $industry;

    /**
     * Javascript Action
     *
     * @var string
     */
    protected $javascriptAction;

    /**
     * Javascript Function
     *
     * @var string
     */
    protected $javascriptFunction;

    /**
     * Job Location
     *
     * @var string
     */
    protected $location;

    /**
     * Job Maximum Salary
     *
     * @var string
     */
    protected $maximumSalary;

    /**
     * Job Minimum Salary
     *
     * @var string
     */
    protected $minimumSalary;

    /**
     * Job Query
     *
     * @var string
     */
    protected $query;

    /**
     * Job Source
     *
     * @var string
     */
    protected $source;

    /**
     * Job Id
     *
     * @var string
     */
    protected $sourceId;

    /**
     * Job Start Date
     *
     * @var string
     */
    protected $startDate;

    /**
     * Create new job
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        array_walk($attributes, function ($value, $key) {
            $this->{$key} = $value;
        });
    }

    /**
     * Magic method to get protected property, if exists
     *
     * @param  string $name
     *
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \OutOfRangeException(sprintf(
                '%s does not contain a property by the name of "%s"',
                __CLASS__,
                $name
            ));
        }

        return $this->{$name};
    }

    // Getters

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        $location = $this->getOrCreateJobLocation();

        return $this->getOrCreatePostalAddress($location)
            ->getAddressLocality();
    }

    /**
     * Get hiring organization description
     *
     * @return string
     */
    public function getCompanyDescription()
    {
        $company = $this->getOrCreateHiringOrganization();

        return $company->getDescription();
    }

    /**
     * Get hiring organization email
     *
     * @return string
     */
    public function getCompanyEmail()
    {
        $company = $this->getOrCreateHiringOrganization();

        return $company->getEmail();
    }

    /**
     * Get hiring organization logo
     *
     * @return string
     */
    public function getCompanyLogo()
    {
        $company = $this->getOrCreateHiringOrganization();

        return $company->getLogo();
    }

    /**
     * Get hiring organization name
     *
     * @return string
     */
    public function getCompanyName()
    {
        $company = $this->getOrCreateHiringOrganization();

        return $company->getName();
    }

    /**
     * Get hiring organization url
     *
     * @return string
     */
    public function getCompanyUrl()
    {
        $company = $this->getOrCreateHiringOrganization();

        return $company->getUrl();
    }

    /**
     * Get core schema types
     *
     * @return array
     */
    public function getCoreSchemaTypes()
    {
        return [self::SERIALIZE_CORE_SCHEMA_LD];
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        $location = $this->getOrCreateJobLocation();

        return $this->getOrCreatePostalAddress($location)
            ->getAddressCountry();
    }

    /**
     * Gets hiringOrganization.
     *
     * @return Organization
     */
    public function getHiringOrganization($parent = false)
    {
        if ($parent) {
            return parent::getHiringOrganization();
        }

        return $this->getOrCreateHiringOrganization();
    }

    /**
     * Gets jobLocation.
     *
     * @return Place
     */
    public function getJobLocation($parent = false)
    {
        if ($parent) {
            return parent::getJobLocation();
        }

        return $this->getOrCreateJobLocation();
    }

    /**
     * Gets latitude.
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->getJobLocation()->getGeo()->getLatitude();
    }

    /**
     * Get linked data schema types
     *
     * @return array
     */
    public function getLinkedDataSchemaTypes()
    {
        return [self::SERIALIZE_STANDARD_LD, self::SERIALIZE_CORE_SCHEMA_LD];
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Gets longitude.
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->getJobLocation()->getGeo()->getLongitude();
    }

    /**
     * Get minimum salary
     *
     * @return float
     */
    public function getMinimumSalary()
    {
        return $this->minimumSalary;
    }

    /**
     * Get postal code
     *
     * @return string
     */
    public function getPostalCode()
    {
        $location = $this->getOrCreateJobLocation();

        return $this->getOrCreatePostalAddress($location)
            ->getPostalCode();
    }

    /**
     * Gets query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Gets source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Gets sourceId.
     *
     * @return string
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        $location = $this->getOrCreateJobLocation();

        return $this->getOrCreatePostalAddress($location)
            ->getAddressRegion();
    }

    /**
     * Get street address
     *
     * @return string
     */
    public function getStreetAddress()
    {
        $location = $this->getOrCreateJobLocation();

        return $this->getOrCreatePostalAddress($location)
            ->getStreetAddress();
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        $location = $this->getOrCreateJobLocation();

        return $location->getTelephone();
    }

    /**
     * Allow class to be serialized with json_encode
     *
     * @param  string $serializeSetting
     *
     * @return array
     */
    public function jsonSerialize($serializeSetting = self::SERIALIZE_STANDARD)
    {
        return $this->serialize($serializeSetting);
    }

    // Setters

    /**
     * Sets baseSalary.
     *
     * @param float $baseSalary
     *
     * @return $this
     */
    public function setBaseSalary($baseSalary)
    {
        $baseSalary = $this->convertCurrency($baseSalary);

        if ($baseSalary) {
            parent::setBaseSalary($baseSalary);
        }

        return $this;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        return $this->updateAddressAttribute('addressLocality', $city);
    }

    /**
     * Set company (simple)
     *
     * @param string $company
     *
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this->setCompanyName($company);
    }

    /**
     * Set hiring organization description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setCompanyDescription($description)
    {
        $company = $this->getOrCreateHiringOrganization();

        $company->setDescription($description);

        return $this->setHiringOrganization($company);
    }

    /**
     * Set hiring organization email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setCompanyEmail($email)
    {
        $company = $this->getOrCreateHiringOrganization();

        $company->setEmail($email);

        return $this->setHiringOrganization($company);
    }

    /**
     * Set hiring organization logo url
     *
     * @param string $logo (image url)
     *
     * @return $this
     */
    public function setCompanyLogo($logo)
    {
        $company = $this->getOrCreateHiringOrganization();

        $company->setLogo($logo);

        return $this->setHiringOrganization($company);
    }

    /**
     * Set hiring organization name
     *
     * @param string $companyName
     *
     * @return $this
     */
    public function setCompanyName($companyName)
    {
        $company = $this->getOrCreateHiringOrganization();

        $company->setName($companyName);

        return $this->setHiringOrganization($company);
    }

    /**
     * Set hiring organization url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setCompanyUrl($url)
    {
        $company = $this->getOrCreateHiringOrganization();

        $company->setUrl($url);

        return $this->setHiringOrganization($company);
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        return $this->updateAddressAttribute('addressCountry', $country);
    }

    /**
     * Sets datePosted.
     *
     * @param string $datePosted
     *
     * @return $this
     */
    public function setDatePostedAsString($datePosted)
    {
        if (strtotime($datePosted) !== false) {
            $datePosted = new DateTime($datePosted);

            $this->setDatePosted($datePosted);
        } else {
            throw new InvalidFormatException;
        }

        return $this;
    }

    /**
     * Set latitude.
     *
     * @param string $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $location = $this->getOrCreateJobLocation();
        $geo = $location->getGeo();
        $geo->setLatitude($latitude);
        $location->setGeo($geo);
        $this->setJobLocation($location);

        return $this;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Set longitude.
     *
     * @param string $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $location = $this->getOrCreateJobLocation();
        $geo = $location->getGeo();
        $geo->setLongitude($longitude);
        $location->setGeo($geo);
        $this->setJobLocation($location);

        return $this;
    }

    /**
     * Set minimum salary
     *
     * @param mixed $salary
     *
     * @return $this
     */
    public function setMinimumSalary($salary)
    {
        $this->minimumSalary = $salary;

        return $this->setBaseSalary($salary);
    }

    /**
     * Sets occupationalCategory with code and title as input
     *
     * @param string $code
     * @param string $title
     *
     * @return $this
     */
    public function setOccupationalCategoryWithCodeAndTitle($code, $title)
    {
        if ($code && $title) {
            $this->setOccupationalCategory($code . ' - ' . $title);
        }

        return $this;
    }

    /**
     * Set postal code
     *
     * @param string $postalCode
     *
     * @return $this
     */
    public function setPostalCode($postalCode)
    {
        return $this->updateAddressAttribute('postalCode', $postalCode);
    }

    /**
     * Sets query.
     *
     * @param string $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Sets source.
     *
     * @param string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Sets sourceId.
     *
     * @param string $sourceId
     *
     * @return $this
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        return $this->updateAddressAttribute('addressRegion', $state);
    }

    /**
     * Set street address
     *
     * @param string $streetAddress
     *
     * @return $this
     */
    public function setStreetAddress($streetAddress)
    {
        if (preg_match('/po box/', strtolower($streetAddress))) {
            $this->updateAddressAttribute('postOfficeBoxNumber', $streetAddress);
        }

        return $this->updateAddressAttribute('streetAddress', $streetAddress);
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return $this
     */
    public function setTelephone($telephone)
    {
        $organization = $this->getOrCreateHiringOrganization()
            ->setTelephone($telephone);
        $location = $this->getOrCreateJobLocation()
            ->setTelephone($telephone);

        return $this->setHiringOrganization($organization)
            ->setJobLocation($location);
    }

    /**
     * Serialize class as json
     *
     * @param  string $serializeSetting
     *
     * @return string
     */
    public function toJson($serializeSetting = self::SERIALIZE_STANDARD)
    {
        return json_encode($this->jsonSerialize($serializeSetting));
    }

    // Private Methods

    /**
     * Attempt to convert currency to float
     *
     * @param  mixed $amount
     *
     * @return float|null
     */
    private function convertCurrency($amount)
    {
        $amount = preg_replace('/[^\\d.]+/', '', $amount);

        if (is_numeric($amount)) {
            return (float) $amount;
        }

        return null;
    }

    /**
     * Gets hiring org if it exists or creates if it doesn't
     *
     * @return Organization
     */
    private function getOrCreateHiringOrganization()
    {
        $company = $this->getHiringOrganization(true);

        if (!$company) {
            $company = new Organization;
        }

        return $company;
    }

    /**
     * Gets jobLocation if it exists or creates if it doesn't
     *
     * @return Place
     */
    private function getOrCreateJobLocation()
    {
        $location = $this->getJobLocation(true);

        if (!$location) {
            $location = new Place;
            $geo = new GeoCoordinates;
            $location->setGeo($geo);
        }

        return $location;
    }

    /**
     * Gets address from location if it exists or creates if it doesn't
     *
     * @param Place $location
     *
     * @return PostalAddress
     */
    private function getOrCreatePostalAddress(Place $location)
    {
        $address = $location->getAddress();

        if (!$address) {
            $address = new PostalAddress;
        }

        return $address;
    }

    /**
     * Attempt to update commonly shared address information
     *
     * @param  string $attribute
     * @param  string $value
     *
     * @return $this
     */
    private function updateAddressAttribute($attribute, $value)
    {
        $organization = $this->getOrCreateHiringOrganization();
        $location = $this->getOrCreateJobLocation();
        $address = $this->getOrCreatePostalAddress($location);

        $setMethod = 'set'.ucfirst($attribute);

        if (method_exists($address, $setMethod)) {
            $address->$setMethod($value);
        }

        $organization->setAddress($address);
        $location->setAddress($address);

        $this->setHiringOrganization($organization);
        $this->setJobLocation($location);

        return $this;
    }
}
