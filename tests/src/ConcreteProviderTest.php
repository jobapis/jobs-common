<?php namespace JobApis\Jobs\Client\Tests;

use Mockery as m;
use JobApis\Jobs\Client\Fixtures\ConcreteProvider;

class ConcreteProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // $this->client = new ConcreteProvider();
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
        // var_dump($client); exit;
    }
}
