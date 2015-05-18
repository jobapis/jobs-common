<?php namespace JobBrander\Jobs\Client;

use \DateTime;
use \JsonSerializable;
use JobBrander\Jobs\Client\Exceptions\InvalidFormatException;
use JobBrander\Jobs\Client\Schema\Entity\JobPosting;
use JobBrander\Jobs\Client\Schema\Entity\Organization;
use JobBrander\Jobs\Client\Schema\Entity\Place;
use JobBrander\Jobs\Client\Schema\Entity\PostalAddress;

/**
 * @method string getAlternateName()
 * @method float getBaseSalary()
 * @method string getCity()
 * @method string getCompany()
 * @method string getCompanyDescription()
 * @method string getCompanyEmail()
 * @method string getCompanyLogo()
 * @method string getCompanyName()
 * @method string getCompanyUrl()
 * @method string getCountry()
 * @method \DateTime getDatePosted()
 * @method string getDescription()
 * @method string getEducationRequirements()
 * @method string getEmploymentType()
 * @method string getEndDate()
 * @method string getExperienceRequirements()
 * @method Organization getHiringOrganization()
 * @method string getIncentiveCompensation()
 * @method string getIndustry()
 * @method string getJavascriptAction()
 * @method string getJavascriptFunction()
 * @method string getJobBenefits()
 * @method Place getJobLocation()
 * @method string getLocation()
 * @method string getOccupationalCategory()
 * @method string getName()
 * @method string getMaximumSalary()
 * @method string getMinimumSalary()
 * @method string getPostalCode()
 * @method string getQualifications()
 * @method string getQuery()
 * @method string getResponsibilities()
 * @method string getSalaryCurrency()
 * @method string getSkills()
 * @method string getSource()
 * @method string getSourceId()
 * @method string getSpecialCommitments()
 * @method string getStartDate()
 * @method string getState()
 * @method string getStreetAddress()
 * @method string getTelephone()
 * @method string getTitle()
 * @method string getType()
 * @method string getUrl()
 * @method string getWorkHours()
 * @method array jsonSerialize()
 * @method Job setAlternateName($value)
 * @method Job setBaseSalary($value)
 * @method Job setCity($value)
 * @method Job setCompany($value)
 * @method Job setCompanyDescription($value)
 * @method Job setCompanyEmail($value)
 * @method Job setCompanyLogo($value)
 * @method Job setCompanyName($value)
 * @method Job setCompanyUrl($value)
 * @method Job setCountry($value)
 * @method Job setDatePosted($value)
 * @method Job setDatePostedAsString($value)
 * @method Job setDescription($value)
 * @method Job setEducationRequirements($value)
 * @method Job setEmploymentType($value)
 * @method Job setEndDate($value)
 * @method Job setExperienceRequirements($value)
 * @method Job setHiringOrganization($value)
 * @method Job getIncentiveCompensation($value)
 * @method Job setIndustry($value)
 * @method Job setJavascriptAction($action)
 * @method Job setJavascriptFunction($function)
 * @method Job setJobBenefits($value)
 * @method Job setJobLocation($value)
 * @method Job setLocation($value)
 * @method Job setMaximumSalary($value)
 * @method Job setMinimumSalary($value)
 * @method Job setName($value)
 * @method Job setOccupationalCategory($value)
 * @method Job setOccupationalCategoryWithCodeAndTitle($code, $title)
 * @method Job setPostalCode($value)
 * @method Job setQualifications($value)
 * @method Job setQuery($value)
 * @method Job setResponsibilities($value)
 * @method Job setSalaryCurrency($value)
 * @method Job setSkills($value)
 * @method Job setSource($value)
 * @method Job setSourceId($value)
 * @method Job setSpecialCommitments($value)
 * @method Job setStartDate($value)
 * @method Job setState($value)
 * @method Job setStreetAddress($value)
 * @method Job setTelephone($value)
 * @method Job setTitle($value)
 * @method Job setType($value)
 * @method Job setUrl($value)
 * @method Job setWorkHours($value)
 * @method string toJson()
 */
class Job extends JobPosting implements JsonSerializable
{
    use AttributeTrait, JsonLinkedDataTrait;

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
     * Job Type
     *
     * @var string
     */
    protected $type;

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
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
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
     * Gets type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Allow class to be serialized with json_encode
     *
     * @param  boolean $useStrict
     *
     * @return array
     */
    public function jsonSerialize($useStrict = false)
    {
        return $this->serialize($useStrict);
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
     * Serialize class as json
     *
     * @param  boolean $useStrict
     *
     * @return string
     */
    public function toJson($useStrict = false)
    {
        return json_encode($this->jsonSerialize($useStrict));
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
     * Gets hiring orgif it exists or creates if it doesn't
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
