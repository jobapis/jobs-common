<?php namespace JobApis\Jobs\Client\Tests;

use JobApis\Jobs\Client\Fixtures\ConcreteQuery;
use Mockery as m;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = new ConcreteQuery();
    }

    public function testItCanInstantiateQueryWithValues()
    {
        $attributes = [
            'keyword' => uniqid(),
        ];
        $query = new ConcreteQuery($attributes);

        foreach ($attributes as $key => $value) {
            $this->assertEquals($value, $query->get($key));
        }
    }

    public function testItCanInstantiateQueryWithDefaultValues()
    {
        $this->assertEquals('1', $this->query->get('highlight'));
    }

    public function testItCanSetAndGetValidAttribute()
    {
        $key = 'keyword';
        $value = uniqid();

        $this->query->set($key, $value);

        $this->assertEquals($value, $this->query->get($key));
    }

    public function testItCanSetAttributeWithCustomMethod()
    {
        $key = 'sampleAttribute1';
        $value = uniqid();

        $this->query->set($key, $value);

        $this->assertEquals(strrev($value), $this->query->get($key));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testItThrowsErrorWhenSettingInvalidAttribute()
    {
        $key = uniqid();
        $value = uniqid();

        $this->query->set($key, $value);
    }

    public function testItCanGetAttributeWithCustomMethod()
    {
        $key = 'sampleAttribute2';
        $value = uniqid();

        $this->query->set($key, $value);

        $this->assertEquals(strrev($value), $this->query->get($key));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testItThrowsErrorWhenGettingInvalidAttribute()
    {
        $key = uniqid();

        $this->query->get($key);
    }

    public function testItCanGetHttpOptions()
    {
        $this->assertEquals([], $this->query->getHttpMethodOptions());
    }

    public function testItCanGetQueryString()
    {
        $query = $this->query->getQueryString();
        $this->assertEquals('?highlight=1', $query);
    }

    public function testItCanGetQueryUrl()
    {
        $query = $this->query->getQueryString();
        $baseUrl = $this->query->getBaseUrl();

        $url = $this->query->getUrl();

        $this->assertEquals($baseUrl.$query, $url);
    }

    public function testItCanGetHttpVerb()
    {
        $this->assertEquals('GET', $this->query->getVerb());
    }

    public function testItReturnsFalseWhenQueryInvalid()
    {
        $valid = $this->query->isValid();
        $this->assertFalse($valid);
    }

    public function testItReturnsTrueWhenQueryValid()
    {
        $query = $this->query;

        $query->set('api_key', uniqid());

        $valid = $query->isValid();

        $this->assertTrue($valid);
    }

}
