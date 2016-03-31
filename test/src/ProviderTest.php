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
        $params = [];
        $this->client->shouldReceive('getVerb')->andReturn($verb);

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

    public function testItCanGetJobsValidJson()
    {
        $provider = $this->getProviderAttributes();

        $payload = [$provider['path'] => []];

        for ($i = 0; $i < $provider['jobs_count']; $i++) {
            array_push($payload[$provider['path']], ['title' => uniqid()]);
        }

        $responseBody = json_encode($payload);

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($provider['keyword'])
            ->times($provider['jobs_count'])->andReturnSelf();
        $job->shouldReceive('setSource')->with($provider['source'])
            ->times($provider['jobs_count'])->andReturnSelf();

        $this->client->shouldReceive('getKeyword')->andReturn($provider['keyword']);
        $this->client->shouldReceive('createJobObject')->times($provider['jobs_count'])->andReturn($job);
        $this->client->shouldReceive('getFormat')->andReturn($provider['format']);
        $this->client->shouldReceive('getSource')->andReturn($provider['source']);
        $this->client->shouldReceive('getListingsPath')->andReturn($provider['path']);
        $this->client->shouldReceive('getParameters')->andReturn($provider['params']);
        $this->client->shouldReceive('getUrl')->andReturn($provider['url']);
        $this->client->shouldReceive('getVerb')->andReturn($provider['verb']);

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn($responseBody);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($provider['verb']))
            ->with($provider['url'], $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($provider['jobs_count'], $results);
    }

    public function testItCanNotGetJobsInvalidJson()
    {
        $provider = $this->getProviderAttributes([ 'path' => '', 'jobs_count' => 0 ]);

        $responseBody = uniqid();

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($provider['keyword'])
            ->times($provider['jobs_count'])->andReturnSelf();
        $job->shouldReceive('setSource')->with($provider['source'])
            ->times($provider['jobs_count'])->andReturnSelf();

        $this->client->shouldReceive('getKeyword')->andReturn($provider['keyword']);
        $this->client->shouldReceive('createJobObject')->times($provider['jobs_count'])->andReturn($job);
        $this->client->shouldReceive('getFormat')->andReturn($provider['format']);
        $this->client->shouldReceive('getSource')->andReturn($provider['source']);
        $this->client->shouldReceive('getListingsPath')->andReturn($provider['path']);
        $this->client->shouldReceive('getParameters')->andReturn($provider['params']);
        $this->client->shouldReceive('getUrl')->andReturn($provider['url']);
        $this->client->shouldReceive('getVerb')->andReturn($provider['verb']);

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn($responseBody);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($provider['verb']))
            ->with($provider['url'], $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($provider['jobs_count'], $results);
    }

    public function testItCanGetJobsValidXml()
    {
        $provider = $this->getProviderAttributes([
            'path' => 'a'.uniqid(), 'format' => 'xml'
        ]);

        $payload = [$provider['path'] => []];

        $responseBody = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><Root>";

        for ($i = 0; $i < $provider['jobs_count']; $i++) {
            $title = uniqid();
            $path = $provider['path'];
            array_push($payload[$provider['path']], ['title' => $title]);
            $responseBody .= "<$path><title><![CDATA[$title]]></title></$path>";
        }

        $responseBody .= "</Root>";

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($provider['keyword'])
            ->times($provider['jobs_count'])->andReturnSelf();
        $job->shouldReceive('setSource')->with($provider['source'])
            ->times($provider['jobs_count'])->andReturnSelf();

        $this->client->shouldReceive('getKeyword')->andReturn($provider['keyword']);
        $this->client->shouldReceive('createJobObject')->times($provider['jobs_count'])->andReturn($job);
        $this->client->shouldReceive('getFormat')->andReturn($provider['format']);
        $this->client->shouldReceive('getSource')->andReturn($provider['source']);
        $this->client->shouldReceive('getListingsPath')->andReturn($provider['path']);
        $this->client->shouldReceive('getParameters')->andReturn($provider['params']);
        $this->client->shouldReceive('getUrl')->andReturn($provider['url']);
        $this->client->shouldReceive('getVerb')->andReturn($provider['verb']);

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn($responseBody);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($provider['verb']))
            ->with($provider['url'], $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($provider['jobs_count'], $results);
    }

    public function testItCanNotGetJobsInvalidXml()
    {
        $provider = $this->getProviderAttributes([
            'path' => '', 'format' => 'xml', 'jobs_count' => 0
        ]);
        $responseBody = uniqid();

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($provider['keyword'])
            ->times($provider['jobs_count'])->andReturnSelf();
        $job->shouldReceive('setSource')->with($provider['source'])
            ->times($provider['jobs_count'])->andReturnSelf();

        $this->client->shouldReceive('getKeyword')->andReturn($provider['keyword']);
        $this->client->shouldReceive('createJobObject')->times($provider['jobs_count'])->andReturn($job);
        $this->client->shouldReceive('getFormat')->andReturn($provider['format']);
        $this->client->shouldReceive('getSource')->andReturn($provider['source']);
        $this->client->shouldReceive('getListingsPath')->andReturn($provider['path']);
        $this->client->shouldReceive('getParameters')->andReturn($provider['params']);
        $this->client->shouldReceive('getUrl')->andReturn($provider['url']);
        $this->client->shouldReceive('getVerb')->andReturn($provider['verb']);

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn($responseBody);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($provider['verb']))
            ->with($provider['url'], $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($provider['jobs_count'], $results);
    }

    public function testItCanNotGetJobsInvalidFormat()
    {
        $provider = $this->getProviderAttributes([
            'path' => '', 'format' => uniqid(), 'jobs_count' => 0
        ]);
        $responseBody = uniqid();

        $job = m::mock($this->jobClass);
        $job->shouldReceive('setQuery')->with($provider['keyword'])
            ->times($provider['jobs_count'])->andReturnSelf();
        $job->shouldReceive('setSource')->with($provider['source'])
            ->times($provider['jobs_count'])->andReturnSelf();

        $this->client->shouldReceive('getKeyword')->andReturn($provider['keyword']);
        $this->client->shouldReceive('createJobObject')->times($provider['jobs_count'])->andReturn($job);
        $this->client->shouldReceive('getFormat')->andReturn($provider['format']);
        $this->client->shouldReceive('getSource')->andReturn($provider['source']);
        $this->client->shouldReceive('getListingsPath')->andReturn($provider['path']);
        $this->client->shouldReceive('getParameters')->andReturn($provider['params']);
        $this->client->shouldReceive('getUrl')->andReturn($provider['url']);
        $this->client->shouldReceive('getVerb')->andReturn($provider['verb']);

        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getBody')->once()->andReturn($responseBody);

        $http = m::mock('GuzzleHttp\Client');
        $http->shouldReceive(strtolower($provider['verb']))
            ->with($provider['url'], $this->client->getHttpClientOptions())
            ->once()
            ->andReturn($response);
        $this->client->setClient($http);

        $results = $this->client->getJobs();

        $this->assertInstanceOf($this->collectionClass, $results);
        $this->assertCount($provider['jobs_count'], $results);
    }

    public function testItCanParseLocationWithoutSeparator()
    {
        $seg1 = uniqid();
        $seg2 = uniqid();
        $string = $seg1.', '.$seg2;

        $results = $this->client->parseLocation($string);

        $this->assertEquals($seg1, $results[0]);
        $this->assertEquals($seg2, $results[1]);
    }

    public function testItCanParseLocationWithSeparator()
    {
        $seg1 = uniqid();
        $seg2 = uniqid();
        $seperator = uniqid();
        $string = $seg1.$seperator.$seg2;

        $results = $this->client->parseLocation($string, $seperator);

        $this->assertEquals($seg1, $results[0]);
        $this->assertEquals($seg2, $results[1]);
    }

    private function getProviderAttributes($attributes = [])
    {
        $defaults = [
            'url' => uniqid(),
            'verb' => uniqid(),
            'path' => uniqid(),
            'format' => 'json',
            'keyword' => uniqid(),
            'source' => uniqid(),
            'params' => [uniqid()],
            'jobs_count' => rand(2,10),
        ];
        return array_replace($defaults, $attributes);
    }

}
