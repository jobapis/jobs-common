<?php namespace JobBrander\Jobs\Client;

use \DateTime;
use JobBrander\Jobs\Client\Exceptions\InvalidFormatException;
use JobBrander\Jobs\Client\Schema\Entity\JobPosting;
use JobBrander\Jobs\Client\Schema\Entity\Organization;
use JobBrander\Jobs\Client\Schema\Entity\Place;
use JobBrander\Jobs\Client\Schema\Entity\PostalAddress;

/**
 * @method Job addCodes($value)
 * @method Job getId()
 * @method Job getTitle()
 * @method Job getDescription()
 * @method Job getSource()
 * @method Job getUrl()
 * @method Job getQuery()
 * @method Job getType()
 * @method Job getCompany()
 * @method Job getLocation()
 * @method Job getIndustry()
 * @method Job getStartDate()
 * @method Job getEndDate()
 * @method Job getMinimumSalary()
 * @method Job getMaximumSalary()
 * @method Job getCodes()
 * @method Job setId($value)
 * @method Job setTitle($value)
 * @method Job setDescription($value)
 * @method Job setSource($value)
 * @method Job setUrl($value)
 * @method Job setQuery($value)
 * @method Job setType($value)
 * @method Job setStartDate($value)
 * @method Job setEndDate($value)
 * @method Job setMinimumSalary($value)
 * @method Job setMaximumSalary($value)
 * @method Job setCompany($value)
 * @method Job setLocation($value)
 * @method Job setIndustry($value)
 * @method Job setCodes($value)
 */
class Job extends JobPosting
{
    use AttributeTrait;

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
     * Job Query
     *
     * @var string
     */
    protected $query;

    /**
     * Job Type
     *
     * @var string
     */
    protected $type;

    /**
     * Job Start Date
     *
     * @var string
     */
    protected $startDate;

    /**
     * Job End Date
     *
     * @var string
     */
    protected $endDate;

    /**
     * Job Minimum Salary
     *
     * @var string
     */
    protected $minimumSalary;

    /**
     * Job Maximum Salary
     *
     * @var string
     */
    protected $maximumSalary;

    /**
     * Job Company
     *
     * @var string
     */
    protected $company;

    /**
     * Job Location
     *
     * @var string
     */
    protected $location;

    /**
     * Job Industry
     *
     * @var string
     */
    protected $industry;

    /**
     * Job Codes
     *
     * @var array
     */
    protected $codes = [];

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
     * Set minimum salary
     *
     * @param float $salary
     *
     * @return $this
     */
    public function setMinimumSalary($salary)
    {
        $this->minimumSalary = $salary;

        return $this->setBaseSalary($salary);
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
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
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
     * Gets query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
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
     * Gets source.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets sourceId.
     *
     * @param int $sourceId
     *
     * @return $this
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Gets sourceId.
     *
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Sets type.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Gets type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Gets hiringOrganization.
     *
     * @return Organization
     */
    public function getHiringOrganization()
    {
        return $this->getOrCreateHiringOrganization();
    }

    /**
     * Gets jobLocation.
     *
     * @return Place
     */
    public function getJobLocation()
    {
        return $this->getOrCreateJobLocation();
    }

    /**
     * Gets jobLocation if it exists or creates if it doesn't
     *
     * @return Place
     */
    private function getOrCreateJobLocation()
    {
        $location = parent::getJobLocation();

        if (!$location) {
            $location = new Place;
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
     * Gets hiring orgif it exists or creates if it doesn't
     *
     * @return Organization
     */
    private function getOrCreateHiringOrganization()
    {
        $company = parent::getHiringOrganization();

        if (!$company) {
            $company = new Organization;
        }

        return $company;
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
}
