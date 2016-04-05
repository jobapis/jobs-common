# Changelog
All Notable changes to `jobs-common` will be documented in this file

## 2.0.0-alpha - 2016-04-04

### Added
- Required parameters
- Inputs as query parameter array rather than attributes on the provider object

### Deprecated
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## 1.0.4 - 2015-10-28

### Added
- toArray method to Schema entities

### Deprecated
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## 1.0.3 - 2015-08-05

### Added
- Implemented the getParameters method in abstract provider
- Location Parser helper method

### Deprecated
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## 1.0.2 - 2015-07-27

### Added
- Remove allowed failures from test suite

### Deprecated
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## 1.0.1 - 2015-07-25

### Added
- `LIBXML_NOCDATA` parameter to XML parser in provider to support CDATA fields

### Deprecated
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## 1.0.0 - 2015-07-03

### Added
- Version 1.0.0 Release

### Deprecated
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## 0.7.0 - 2015-06-07

### Added
- Support for Guzzle v.6.0 in abstract provider

### Deprecated
- xml() and json() methods previously used in provider are no longer supported by Guzzle

### Fixed
- Nothing

### Security
- Nothing

## 0.6.1 - 2015-05-27

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Guzzle upgrade to v.6 was breaking our XML feeds, so I downgraded to require v.5.x

### Security
- Nothing

## 0.6.0 - 2015-05-26

### Added
- Nothing

### Deprecated
- "type" attribute from Job class (use employmentType from now on)

### Fixed
- Support for XML feeds

### Security
- Nothing

## 0.5.1 - 2015-05-15

### Added
- Support for Schema.org [2.0 release](http://blog.schema.org/2015/05/schema.html)
- Added "jobBenefits" attribute to JobPosting class
- Added "incentiveCompensation" attribute to JobPosting class

### Deprecated
- Removed "benefits" attribute from JobPosting class
- Removed "incentives" attribute from JobPosting class

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.5.0 - 2015-05-15

### Added
- setOccupationalCategory method to help add standardized code/category as
specified by schema.org Job Posting
- Attributes javascriptAction and javascriptFunction replace codes
array attribute

### Deprecated
- "codes" attribute removed
- AddToArray in trait (no more arrays exist in job attributes)
- IsAdderMethod because no more adders

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.4.1 - 2015-05-14

### Added
- Helper function to set date from string
- Convert strings in base salary to currency format

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.4.0 - 2015-05-08

### Added
- Support for Schema.org Job Posting element
- Methods to add Schema.org Hiring Organization and Location to jobs
- Add sourceId attribute to job

### Deprecated
- Job id attribute

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.3.1 - 2015-05-02

### Added
- Added visibility to getJobsCollectionFromListings method

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.3.0 - 2015-05-02

### Added
- Added support for Job Start date
- Added support for Job End date
- Added support for Job Minimum Salary
- Added support for Job Maximum Salary
- Added support for Job Company
- Added support for Job Industry
- Added support for Job Location
- Improved support for source attribution

### Deprecated
- Job Companies
- Job Industries
- Job Locations
- Job Dates

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.2.0 - 2015-04-13

### Added
- Array support for Job properties, companies, locations, industries, dates, salaries, codes

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.1.0 - 2015-04-10

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing
