<?php namespace JobBrander\Jobs\Client\Test;

use Mockery as m;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    private $clientClass = 'JobBrander\Jobs\Client\Providers\AbstractProvider';
    private $collectionClass = 'JobBrander\Jobs\Client\Collection';
    private $jobClass = 'JobBrander\Jobs\Client\Job';

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
        $format = uniqid();
        $keyword = uniqid();
        $source = uniqid();
        $params = [uniqid()];
        $jobs_count = rand(2,10);
        $payload = [$path => []];

        for ($i = 0; $i < $jobs_count; $i++) {
            array_push($payload[$path], ['title' => uniqid()]);
        }

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($keyword)->times($jobs_count)->andReturnSelf();
        $job->shouldReceive('setSource')->with($source)->times($jobs_count)->andReturnSelf();

        $this->client->keyword = $keyword;
        $this->client->shouldReceive('createJobObject')->times($jobs_count)->andReturn($job);
        $this->client->shouldReceive('getFormat')->andReturn($format);
        $this->client->shouldReceive('getSource')->andReturn($source);
        $this->client->shouldReceive('getListingsPath')->andReturn($path);
        $this->client->shouldReceive('getParameters')->andReturn($params);
        $this->client->shouldReceive('getUrl')->andReturn($url);
        $this->client->shouldReceive('getVerb')->andReturn($verb);

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive($format)->once()->andReturn($payload);

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

    public function testItCanExtractRawListingDataFromPayloadWhenPathProvided()
    {
        $path = 'results.jobs';
        $jobs = [uniqid(), uniqid()];
        $payload = ['results' => ['jobs' => $jobs]];
        $this->client->shouldReceive('getListingsPath')->once()->andReturn($path);

        $listings = $this->client->getRawListings($payload);

        $this->assertEquals($jobs, $listings);
    }

    public function testItCanNotExtractRawListingDataFromPayloadWhenPathNotProvided()
    {
        $path = '';
        $jobs = [uniqid(), uniqid()];
        $payload = ['results' => ['jobs' => $jobs]];
        $this->client->shouldReceive('getListingsPath')->once()->andReturn($path);

        $listings = $this->client->getRawListings($payload);

        $this->assertEquals($payload, $listings);
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testItCanNotGetValueWhenIndexIsEmpty()
    {
        $value = $this->client->getValue(null, null);
    }

    public function testItCanGetSource()
    {
        $source = $this->client->getSource();

        $this->assertNotNull($source);
    }
}
