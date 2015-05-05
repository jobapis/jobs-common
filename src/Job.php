<?php namespace JobBrander\Jobs\Client;

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
 * @method Job getMinimumSalariy()
 * @method Job getMaximumSalariy()
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
     * Get street address
     *
     * @return string
     */
    public function getStreetAddress()
    {
        $location = $this->getJobLocation();

        if ($location) {
            $address = $location->getAddress();

            if ($address) {
                return $address->getStreetAddress();
            }
        }

        return null;
    }

    /**
     * Set street address
     *
     * @param string $street_address
     *
     * @return $this
     */
    public function setStreetAddress($street_address)
    {
        $location = $this->getOrCreateJobLocation();

        $address = $this->getOrCreatePostalAddress($location);

        $address->setStreetAddress($street_address);

        $location->setAddress($address);

        return $this->setJobLocation($location);
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        $location = $this->getJobLocation();

        if ($location) {
            $address = $location->getAddress();

            if ($address) {
                return $address->getAddressLocality();
            }
        }

        return null;
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
        $location = $this->getOrCreateJobLocation();

        $address = $this->getOrCreatePostalAddress($location);

        $address->setAddressLocality($city);

        $location->setAddress($address);

        return $this->setJobLocation($location);
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        $location = $this->getJobLocation();

        if ($location) {
            $address = $location->getAddress();

            if ($address) {
                return $address->getAddressRegion();
            }
        }

        return null;
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
        $location = $this->getOrCreateJobLocation();

        $address = $this->getOrCreatePostalAddress($location);

        $address->setAddressRegion($state);

        $location->setAddress($address);

        return $this->setJobLocation($location);
    }

    /**
     * Get postal code
     *
     * @return string
     */
    public function getPostalCode()
    {
        $location = $this->getJobLocation();

        if ($location) {
            $address = $location->getAddress();

            if ($address) {
                return $address->getPostalCode();
            }
        }

        return null;
    }

    /**
     * Set postal code
     *
     * @param string $postal_code
     *
     * @return $this
     */
    public function setPostalCode($postal_code)
    {
        $location = $this->getOrCreateJobLocation();

        $address = $this->getOrCreatePostalAddress($location);

        $address->setPostalCode($postal_code);

        $location->setAddress($address);

        return $this->setJobLocation($location);
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        $location = $this->getJobLocation();

        if ($location) {
            $address = $location->getAddress();

            if ($address) {
                return $address->getAddressCountry();
            }
        }

        return null;
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
        $location = $this->getOrCreateJobLocation();

        $address = $this->getOrCreatePostalAddress($location);

        $address->setAddressCountry($country);

        $location->setAddress($address);

        return $this->setJobLocation($location);
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        $location = $this->getJobLocation();

        if ($location) {
            return $location->getTelephone();
        }

        return null;
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
        $location = $this->getOrCreateJobLocation();

        $location->setTelephone($telephone);

        return $this->setJobLocation($location);
    }

    /**
     * Get hiring organization name
     *
     * @return string
     */
    public function getCompanyName()
    {
        $company = $this->getHiringOrganization();

        if ($company) {
            return $company->getName();
        }

        return null;
    }

    /**
     * Set hiring organization name
     *
     * @param string $company_name
     *
     * @return $this
     */
    public function setCompanyName($company_name)
    {
        $company = $this->getOrCreateHiringOrganization();

        $company->setName($company_name);

        return $this->setHiringOrganization($company);
    }

    /**
     * Get hiring organization description
     *
     * @return string
     */
    public function getCompanyDescription()
    {
        $company = $this->getHiringOrganization();

        if ($company) {
            return $company->getDescription();
        }

        return null;
    }

    /**
     * Set hiring organization description
     *
     * @param string $company_name
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
        $company = $this->getHiringOrganization();

        if ($company) {
            return $company->getLogo();
        }

        return null;
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
        $company = $this->getHiringOrganization();

        if ($company) {
            return $company->getEmail();
        }

        return null;
    }

    /**
     * Set hiring organization email
     *
     * @param string $company_name
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
        $company = $this->getHiringOrganization();

        if ($company) {
            return $company->getUrl();
        }

        return null;
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

    private function getOrCreateJobLocation()
    {
        $location = $this->getJobLocation();

        if (!$location) {
            $location = new Place;
        }

        return $location;
    }

    private function getOrCreatePostalAddress($location)
    {
        $address = $location->getAddress();

        if (!$address) {
            $address = new PostalAddress;
        }

        return $address;
    }

    private function getOrCreateHiringOrganization()
    {
        $company = $this->getHiringOrganization();

        if (!$company) {
            $company = new Organization;
        }

        return $company;
    }
}
