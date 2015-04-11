<?php namespace JobBrander\Jobs\Test\Providers;

use JobBrander\Jobs\Providers\AbstractClient;
use JobBrander\Jobs\Collection;
use JobBrander\Jobs\Job;
use Mockery as m;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $clientClass = 'JobBrander\Jobs\Providers\AbstractClient';
    private $collectionClass = 'JobBrander\Jobs\Collection';
    private $jobClass = 'JobBrander\Jobs\Job';

    public function setUp()
    {
        $this->client = m::mock($this->clientClass)
            ->shouldDeferMissing()
            ->shouldAllowMockingProtectedMethods();
    }

    public function testItPopulatesExistingAttributeswhenBuilt()
    {
        $attributes = [
            'city' => uniqid(),
            'count' => rand(),
            'keyword' => uniqid(),
            'page' => rand(),
            'state' => uniqid(),
        ];
        $client = $this->client;
        $reflectedClass = new \ReflectionClass($this->clientClass);
        $constructor = $reflectedClass->getConstructor();

        $constructor->invoke($client, $attributes);

        array_walk($attributes, function ($value, $key) use ($client) {
            $this->assertEquals($value, $client->{$key});
        });
    }

    public function testItCanGetJobs()
    {
        $url = uniqid();
        $verb = uniqid();
        $path = uniqid();
        $keyword = uniqid();
        $jobs_count = rand(2,10);
        $payload = [$path => []];

        for ($i = 0; $i < $jobs_count; $i++) {
            array_push($payload[$path], ['title' => uniqid()]);
        }

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($keyword)->times($jobs_count)->andReturnSelf();

        $this->client->keyword = $keyword;
        $this->client->shouldReceive('createJobObject')->times($jobs_count)->andReturn($job);
        $this->client->shouldReceive('getListingsPath')->once()->andReturn($path);
        $this->client->shouldReceive('getUrl')->once()->andReturn($url);
        $this->client->shouldReceive('getVerb')->once()->andReturn($verb);

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive($this->client->getFormat())->once()->andReturn($payload);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($verb))
            ->with($url, $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($jobs_count, $results);
    }

    public function testDefaultCityIsNull()
    {
        $city = $this->client->city;

        $this->assertNull($city);
    }

    public function testDefaultCountIsTen()
    {
        $default_count = 10;

        $count = $this->client->count;

        $this->assertEquals($default_count, $count);
    }

    public function testDefaultKeywordIsNull()
    {
        $keyword = $this->client->keyword;

        $this->assertNull($keyword);
    }

    public function testDefaultPageIsOne()
    {
        $default_page = 1;

        $page = $this->client->page;

        $this->assertEquals($default_page, $page);
    }

    public function testDefaultStateIsNull()
    {
        $state = $this->client->state;

        $this->assertNull($state);
    }

    public function testItUsesJsonByDefault()
    {
        $default_format = 'json';

        $format = $this->client->getFormat();

        $this->assertEquals($default_format, $format);
    }

    public function testItHttpClientOptionsEmptyWhenVerbIsGet()
    {
        $verb = 'GET';
        $this->client->shouldReceive('getVerb')->andReturn($verb);

        $client_options = $this->client->getHttpClientOptions();

        $this->assertEmpty($client_options);
    }

    public function testItHttpClientOptionsIncludeBodyWhenVerbIsNotGet()
    {
        $verb = uniqid();
        $params = [uniqid()];
        $this->client->shouldReceive('getVerb')->andReturn($verb);
        $this->client->shouldReceive('getParameters')->andReturn($params);

        $client_options = $this->client->getHttpClientOptions();

        $this->assertEquals($params, $client_options['body']);
    }

    public function testItUsesEmptyListingPathByDefault()
    {
        $listing_path = $this->client->getListingsPath();

        $this->assertEmpty($listing_path);
        $this->assertTrue(is_string($listing_path));
    }

    public function testItUsesEmptyParametersByDefault()
    {
        $parameters = $this->client->getParameters();

        $this->assertEmpty($parameters);
        $this->assertTrue(is_array($parameters));
    }

    public function testItUsesGetHttpVerbByDefault()
    {
        $default_verb = 'GET';

        $verb = $this->client->getVerb();

        $this->assertEquals($default_verb, $verb);
    }

    public function testItParsesDefaultAttributes()
    {
        $defaults = [uniqid(), uniqid(), uniqid()];
        $attributes = [];

        $parsed_attributes = $this->client->parseAttributeDefaults($attributes, $defaults);

        array_walk($parsed_attributes, function ($value, $key) use ($defaults) {
            $this->assertContains($key, $defaults);
            $this->assertNull($value);
        });
    }
}
