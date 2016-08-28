<?php namespace JobApis\Jobs\Client\Tests;

use JobApis\Jobs\Client\Fixtures\ConcreteQuery;
use Mockery as m;

class ConcreteProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = new ConcreteQuery();
    }

    public function testItCanInstantiateQuery()
    {
        $attributes = [
            'keyword' => uniqid(),
        ];
        $query = new ConcreteQuery($attributes);

        foreach ($attributes as $key => $value) {
            $this->assertEquals($value, $query->get($key));
        }
    }

    public function testItCanSetValueWithCustomMethod()
    {
        $key = 'sampleAttribute1';
        $value = uniqid();

        $this->query->set($key, $value);

        $this->assertEquals(strrev($value), $this->query->get($key));
    }

    public function testItCanGetValueWithCustomMethod()
    {
        $key = 'sampleAttribute2';
        $value = uniqid();

        $this->query->set($key, $value);

        $this->assertEquals(strrev($value), $this->query->get($key));
    }
}
