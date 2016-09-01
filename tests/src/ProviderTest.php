<?php namespace JobApis\Jobs\Client\Tests;

use Mockery as m;
use JobApis\Jobs\Client\Fixtures\ConcreteProvider;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = m::mock('JobApis\Jobs\Client\Fixtures\ConcreteQuery');
        $this->guzzle = m::mock('GuzzleHttp\Client');
        $this->client = new ConcreteProvider($this->query);
        $this->client->setClient($this->guzzle);
    }

    public function testItCanGetClientResponse()
    {
        $url = 'http://'.uniqid().'.com/api';
        $options = [
            'keyword' => uniqid(),
            'location' => uniqid(),
        ];

        $response = m::mock('\Psr\Http\Message\ResponseInterface');

        $this->query->shouldReceive('getVerb')
            ->once()
            ->andReturn('GET');
        $this->query->shouldReceive('getUrl')
            ->once()
            ->andReturn($url);
        $this->query->shouldReceive('getHttpMethodOptions')
            ->once()
            ->andReturn($options);
        $this->guzzle->shouldReceive('get')
            ->with($url, $options)
            ->once()
            ->andReturn($response);

        $result = $this->client->getClientResponse();

        $this->assertEquals($response, $result);
    }

    public function testItCanGetResponseFormat()
    {
        $this->assertEquals('json', $this->client->getFormat());
    }

    /**
     * @expectedException \JobApis\Jobs\Client\Exceptions\MissingParameterException
     */
    public function testItCannotGetJobsWhenInvalidQueryProvided()
    {
        $this->query->shouldReceive('isValid')
            ->once()
            ->andReturn(false);

        $this->client->getJobs();
    }

    public function testItCanGetSource()
    {
        $this->assertEquals('ConcreteProvider', $this->client->getSource());
    }
    
    // TODO: Test for each method

    public function testItCanGetJobsWhenValidQueryProvided()
    {
        $url = 'http://'.uniqid().'.com/api';
        $options = [
            'keyword' => uniqid(),
            'location' => uniqid(),
        ];

        $response = m::mock('\Psr\Http\Message\ResponseInterface');

        $jobs = json_encode((object) [
            'jobs' => [
                $this->createJob(),
                $this->createJob(),
                $this->createJob(),
            ]
        ]);

        $this->query->shouldReceive('isValid')
            ->once()
            ->andReturn(true);
        $this->query->shouldReceive('getVerb')
            ->once()
            ->andReturn('GET');
        $this->query->shouldReceive('getUrl')
            ->once()
            ->andReturn($url);
        $this->query->shouldReceive('getHttpMethodOptions')
            ->once()
            ->andReturn($options);
        $this->guzzle->shouldReceive('get')
            ->with($url, $options)
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn($jobs);
        $this->query->shouldReceive('getKeyword')
            ->once()
            ->andReturn($options['keyword']);

        $results = $this->client->getJobs();

        $this->assertEquals(\JobApis\Jobs\Client\Collection::class, get_class($results));
        $this->assertEquals(3, count($results));

        foreach ($results as $result) {
            $this->assertNotNull($result->company);
            $this->assertNotNull($result->sourceId);
            $this->assertNotNull($result->title);
        }
    }

    private function createJob()
    {
        return (object) [
            'id' => uniqid(),
            'name' => uniqid(),
            'company' => uniqid(),
            'date' => date('m/d/y'),
            'url' => uniqid(),
        ];
    }
}
