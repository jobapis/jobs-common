# Jobs Common

## Standardizing job board API clients

[![Latest Version](https://img.shields.io/github/release/JobBrander/jobs-common.svg?style=flat-square)](https://github.com/JobBrander/jobs-common/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/JobBrander/jobs-common/master.svg?style=flat-square&1)](https://travis-ci.org/JobBrander/jobs-common)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/JobBrander/jobs-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-common/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/JobBrander/jobs-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/JobBrander/jobs-common)
[![Total Downloads](https://img.shields.io/packagist/dt/jobbrander/jobs-common.svg?style=flat-square)](https://packagist.org/packages/jobbrander/jobs-common)

This package makes it makes it easy to integrate job board APIs into your application. Whether you want to aggregate job board data, or supplement your site's job listings with listings from third party providers, or anything else you can dream up, this package (and the api clients listed below) can help.

This package is compliant with [PSR-1][], [PSR-2][], [PSR-4][], and [PSR-7][]. If you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[PSR-7]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-7-http-message.md

## Requirements

The following versions of PHP are supported.

* PHP 5.5
* PHP 5.6
* PHP 7.0
* HHVM

## Usage
This package is not meant to be used on its own, but rather it is used by the providers listed below to access job board APIs and gather results in a standard data format. For details on creating your own job board provider, read on!

## Providers

Each job board supported has a provider that must extend this package's [AbstractProvider](https://github.com/JobBrander/jobs-common/blob/master/src/Provider/AbstractProvider.php), and implement the declared abstract methods.

The following providers are available:

### Official providers

There are many job board services we support officially.

Gateway | Composer Package | Maintainer
--- | --- | ---
[Authentic Jobs](https://github.com/JobBrander/jobs-authenticjobs) | jobbrander/jobs-authenticjobs| [Steven Maguire](https://github.com/stevenmaguire)
[CareerBuilder](https://github.com/JobBrander/jobs-careerbuilder) | jobbrander/jobs-careerbuilder| [Karl Hughes](https://github.com/karllhughes)
[Careercast](https://github.com/JobBrander/jobs-careercast) | jobbrander/jobs-careercast| [Karl Hughes](https://github.com/karllhughes)
[Dice](https://github.com/JobBrander/jobs-dice) | jobbrander/jobs-dice| [Karl Hughes](https://github.com/karllhughes)
[Elance](https://github.com/JobBrander/jobs-elance) | jobbrander/jobs-elance| [Steven Maguire](https://github.com/stevenmaguire)
[Github Jobs](https://github.com/JobBrander/jobs-github) | jobbrander/jobs-github| [Steven Maguire](https://github.com/stevenmaguire)
[Govt](https://github.com/JobBrander/jobs-govt) | jobbrander/jobs-govt| [Karl Hughes](https://github.com/karllhughes)
[Indeed](https://github.com/JobBrander/jobs-indeed) | jobbrander/jobs-indeed| [Steven Maguire](https://github.com/stevenmaguire)
[Jobs2Careers](https://github.com/JobBrander/jobs-jobs2careers) | jobbrander/jobs-jobs2careers| [Karl Hughes](https://github.com/karllhughes)
[Muse](https://github.com/JobBrander/jobs-muse) | jobbrander/jobs-muse| [Karl Hughes](https://github.com/karllhughes)
[JuJu](https://github.com/JobBrander/jobs-juju) | jobbrander/jobs-juju| [Karl Hughes](https://github.com/karllhughes)
[SimplyHired](https://github.com/JobBrander/jobs-simplyhired) | jobbrander/jobs-simplyhired| [Karl Hughes](https://github.com/karllhughes)
[ZipRecruiter](https://github.com/JobBrander/jobs-ziprecruiter) | jobbrander/jobs-ziprecruiter| [Karl Hughes](https://github.com/karllhughes)

### Third party providers

If you would like to support other providers, please make them available as a Composer package, then link to them
below.

These providers allow integration with other providers not supported by `jobs-common`. They may require an older version
so please help them out with a pull request if you notice this.

Gateway | Composer Package | Maintainer
--- | --- | ---
[Job Crank](http://www.jobcrank.com/) | yourname/jobs-jobcrank | [You!](https://github.com)

### Build your own providers

New providers can be created by cloning the layout of an existing package. When choosing a name for your package, please don’t use the `jobbrander` vendor prefix, as this implies that it is officially supported.

You should use your own username as the vendor prefix, and prepend `jobs-` to the package name to make it clear that your package works with Jobs Client. For example, if your GitHub username was prometheus, and you were implementing the Dice.com job listing library, a good name for your composer package would be `prometheus/jobs-dice`.

#### Implementing your own provider

If you are working with a job board service not supported out-of-the-box or by an existing package, it is quite simple to implement your own. Simply extend `JobBrander\Jobs\Client\Providers\AbstractProvider` and implement the required abstract methods:

```php
abstract public function createJobObject($payload);
abstract public function getFormat();
abstract public function getListingsPath();
abstract public function getKeyword();
abstract public function getVerb();
```

Each of these abstract methods contain a docblock defining their expectations and typical behaviour. Once you have extended this class, you can simply follow the example above using your new `Provider`.

Each job object that is created will automatically set `source` and `query` based on the criteria passed into the provider. If you would like to customize this `source` value, your provider must implement a `getSource` method that returns a string to identify your provider's source.

#### Make your provider official

If you want to transfer your provider to the `jobbrander` GitHub organization and add it to the list of officially supported providers, please open a pull request on the jobbrander/jobs-common package. Before new providers will be accepted, they must have 100% unit test code coverage, and follow the conventions and code style used in other Jobs Client providers.

## Install

Via Composer

``` bash
$ composer require jobbrander/jobs-common
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/jobbrander/jobs-common/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/jobbrander/jobs-common/contributors)


## License

The Apache 2.0. Please see [License File](https://github.com/jobbrander/jobs-common/blob/master/LICENSE) for more information.

:)
