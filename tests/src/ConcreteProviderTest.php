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
            'affiliateUrl' => uniqid(),
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

    /**
     * @expectedException \OutOfRangeException
     */
    public function testItCannotSetInvalidAttributeOnClient()
    {
        $flanken = uniqid();

        $this->client->setFlanken($flanken);
    }
}
