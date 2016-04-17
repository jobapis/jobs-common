<?php

/*
 * This class was automatically generated.
 */

namespace JobBrander\Jobs\Client\Schema\Entity;

/**
 * A listing that describes a job opening in a certain organization.
 *
 * @see http://schema.org/JobPosting Documentation on Schema.org
 */
class JobPosting extends Thing
{
    /**
     * @var float The base salary of the job or of an employee in an EmployeeRole.
     */
    protected $baseSalary;
    /**
     * @var string Description of benefits associated with the job.
     */
    protected $jobBenefits;
    /**
     * @var \DateTime Publication date for the job posting.
     */
    protected $datePosted;
    /**
     * @var string Educational background needed for the position.
     */
    protected $educationRequirements;
    /**
     * @var string Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).
     */
    protected $employmentType;
    /**
     * @var string Description of skills and experience needed for the position.
     */
    protected $experienceRequirements;
    /**
     * @var Organization Organization offering the job position.
     */
    protected $hiringOrganization;
    /**
     * @var string Description of bonus and commission compensation aspects of the job.
     */
    protected $incentiveCompensation;
    /**
     * @var string The industry associated with the job position.
     */
    protected $industry;
    /**
     * @var Place A (typically single) geographic location associated with the job position.
     */
    protected $jobLocation;
    /**
     * @var string Category or categories describing the job.
     * Use BLS O*NET-SOC taxonomy: http://www.onetcenter.org/taxonomy.html.
     * Ideally includes textual label and formal code, with the property
     * repeated for each applicable value.
     */
    protected $occupationalCategory;
    /**
     * @var string Specific qualifications required for this role.
     */
    protected $qualifications;
    /**
     * @var string Responsibilities associated with this role.
     */
    protected $responsibilities;
    /**
     * @var string The currency (coded using ISO 4217,
     * http://en.wikipedia.org/wiki/ISO_4217 ) used for the main salary
     * information in this job posting or for this employee.
     */
    protected $salaryCurrency;
    /**
     * @var string Skills required to fulfill this role.
     */
    protected $skills;
    /**
     * @var string Any special commitments associated with this job
     * posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.
     */
    protected $specialCommitments;
    /**
     * @var string The title of the job.
     */
    protected $title;
    /**
     * @var string The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).
     */
    protected $workHours;

    /**
     * Sets baseSalary.
     *
     * @param float $baseSalary
     *
     * @return $this
     */
    public function setBaseSalary($baseSalary)
    {
        $this->baseSalary = $baseSalary;

        return $this;
    }

    /**
     * Gets baseSalary.
     *
     * @return float
     */
    public function getBaseSalary()
    {
        return $this->baseSalary;
    }

    /**
     * Sets jobBenefits.
     *
     * @param string $jobBenefits
     *
     * @return $this
     */
    public function setJobBenefits($jobBenefits)
    {
        $this->jobBenefits = $jobBenefits;

        return $this;
    }

    /**
     * Gets jobBenefits.
     *
     * @return string
     */
    public function getJobBenefits()
    {
        return $this->jobBenefits;
    }

    /**
     * Sets datePosted.
     *
     * @param \DateTime $datePosted
     *
     * @return $this
     */
    public function setDatePosted(\DateTime $datePosted = null)
    {
        $this->datePosted = $datePosted;

        return $this;
    }

    /**
     * Gets datePosted.
     *
     * @return \DateTime
     */
    public function getDatePosted()
    {
        return $this->datePosted;
    }

    /**
     * Sets educationRequirements.
     *
     * @param string $educationRequirements
     *
     * @return $this
     */
    public function setEducationRequirements($educationRequirements)
    {
        $this->educationRequirements = $educationRequirements;

        return $this;
    }

    /**
     * Gets educationRequirements.
     *
     * @return string
     */
    public function getEducationRequirements()
    {
        return $this->educationRequirements;
    }

    /**
     * Sets employmentType.
     *
     * @param string $employmentType
     *
     * @return $this
     */
    public function setEmploymentType($employmentType)
    {
        $this->employmentType = $employmentType;

        return $this;
    }

    /**
     * Gets employmentType.
     *
     * @return string
     */
    public function getEmploymentType()
    {
        return $this->employmentType;
    }

    /**
     * Sets experienceRequirements.
     *
     * @param string $experienceRequirements
     *
     * @return $this
     */
    public function setExperienceRequirements($experienceRequirements)
    {
        $this->experienceRequirements = $experienceRequirements;

        return $this;
    }

    /**
     * Gets experienceRequirements.
     *
     * @return string
     */
    public function getExperienceRequirements()
    {
        return $this->experienceRequirements;
    }

    /**
     * Sets hiringOrganization.
     *
     * @param Organization $hiringOrganization
     *
     * @return $this
     */
    public function setHiringOrganization(Organization $hiringOrganization = null)
    {
        $this->hiringOrganization = $hiringOrganization;

        return $this;
    }

    /**
     * Gets hiringOrganization.
     *
     * @return Organization
     */
    public function getHiringOrganization()
    {
        return $this->hiringOrganization;
    }

    /**
     * Sets incentiveCompensation.
     *
     * @param string $incentiveCompensation
     *
     * @return $this
     */
    public function setIncentiveCompensation($incentiveCompensation)
    {
        $this->incentiveCompensation = $incentiveCompensation;

        return $this;
    }

    /**
     * Gets incentiveCompensation.
     *
     * @return string
     */
    public function getIncentiveCompensation()
    {
        return $this->incentiveCompensation;
    }

    /**
     * Sets industry.
     *
     * @param string $industry
     *
     * @return $this
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Gets industry.
     *
     * @return string
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Sets jobLocation.
     *
     * @param Place $jobLocation
     *
     * @return $this
     */
    public function setJobLocation(Place $jobLocation = null)
    {
        $this->jobLocation = $jobLocation;

        return $this;
    }

    /**
     * Gets jobLocation.
     *
     * @return Place
     */
    public function getJobLocation()
    {
        return $this->jobLocation;
    }

    /**
     * Sets occupationalCategory.
     *
     * @param string $occupationalCategory
     *
     * @return $this
     */
    public function setOccupationalCategory($occupationalCategory)
    {
        $this->occupationalCategory = $occupationalCategory;

        return $this;
    }

    /**
     * Gets occupationalCategory.
     *
     * @return string
     */
    public function getOccupationalCategory()
    {
        return $this->occupationalCategory;
    }

    /**
     * Sets qualifications.
     *
     * @param string $qualifications
     *
     * @return $this
     */
    public function setQualifications($qualifications)
    {
        $this->qualifications = $qualifications;

        return $this;
    }

    /**
     * Gets qualifications.
     *
     * @return string
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }

    /**
     * Sets responsibilities.
     *
     * @param string $responsibilities
     *
     * @return $this
     */
    public function setResponsibilities($responsibilities)
    {
        $this->responsibilities = $responsibilities;

        return $this;
    }

    /**
     * Gets responsibilities.
     *
     * @return string
     */
    public function getResponsibilities()
    {
        return $this->responsibilities;
    }

    /**
     * Sets salaryCurrency.
     *
     * @param string $salaryCurrency
     *
     * @return $this
     */
    public function setSalaryCurrency($salaryCurrency)
    {
        $this->salaryCurrency = $salaryCurrency;

        return $this;
    }

    /**
     * Gets salaryCurrency.
     *
     * @return string
     */
    public function getSalaryCurrency()
    {
        return $this->salaryCurrency;
    }

    /**
     * Sets skills.
     *
     * @param string $skills
     *
     * @return $this
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Gets skills.
     *
     * @return string
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Sets specialCommitments.
     *
     * @param string $specialCommitments
     *
     * @return $this
     */
    public function setSpecialCommitments($specialCommitments)
    {
        $this->specialCommitments = $specialCommitments;

        return $this;
    }

    /**
     * Gets specialCommitments.
     *
     * @return string
     */
    public function getSpecialCommitments()
    {
        return $this->specialCommitments;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets workHours.
     *
     * @param string $workHours
     *
     * @return $this
     */
    public function setWorkHours($workHours)
    {
        $this->workHours = $workHours;

        return $this;
    }

    /**
     * Gets workHours.
     *
     * @return string
     */
    public function getWorkHours()
    {
        return $this->workHours;
    }
}
