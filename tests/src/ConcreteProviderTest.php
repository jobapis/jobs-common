<?php namespace JobApis\Jobs\Client\Tests;

use Mockery as m;
use JobApis\Jobs\Client\Fixtures\ConcreteProvider;

class ConcreteProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->client = new ConcreteProvider();
    }

    public function testItCanInstantiateProviderWithAttributesInConstructor()
    {
        $attributes = [
            'keyword' => uniqid(),
            'ipAddress' => uniqid(),
            'affiliateId' => uniqid(),
        ];
        $client = new ConcreteProvider($attributes);

        foreach ($attributes as $key => $attribute) {
            $method = 'get'.ucwords($key);
            $this->assertEquals($attribute, $client->$method());
        }
    }

    public function testItCanSetValidAttributeOnClient()
    {
        $keyword = uniqid();

        $this->client->setKeyword($keyword);

        $this->assertEquals($keyword, $this->client->getKeyword());
    }

    public function testDefaultParametersAreSetInClient()
    {
        $this->assertNotNull($this->client->getIpAddress());
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testItCannotSetInvalidAttributeOnClient()
    {
        $flanken = uniqid();

        $this->client->setFlanken($flanken);
    }

    public function testItCanSetOptionalTransformedAttributeOnClient()
    {
        $optionalParam = uniqid();

        $this->client->setOptionalParam1($optionalParam);

        $this->assertEquals(strrev($optionalParam), $this->client->getOptionalParam1());
    }

    public function testItCanGetOptionalTransformedAttributeOnClient()
    {
        $optionalParam = uniqid();

        $this->client->setOptionalParam2($optionalParam);

        $this->assertEquals(strrev($optionalParam), $this->client->getOptionalParam2());
    }

    public function testItCanGetJobsWhenRequiredParametersSet()
    {
        $keyword = uniqid();
        $ipAddress = uniqid();
        $affiliateId = uniqid();

        $this->client->setKeyword($keyword);
        $this->client->setIpAddress($ipAddress);
        $this->client->setAffiliateId($affiliateId);

        $jobs = $this->client->getJobs();

        $this->assertInstanceOf('JobApis\Jobs\Client\Collection', $jobs);
    }
}
