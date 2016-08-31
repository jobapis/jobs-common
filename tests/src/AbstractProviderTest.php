<?php namespace JobApis\Jobs\Client\Tests;

use Mockery as m;
use JobApis\Jobs\Client\Fixtures\ConcreteProvider;

class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = m::mock('JobApis\Jobs\Client\Fixtures\ConcreteQuery');
        $this->client = new ConcreteProvider($this->query);
    }

    public function testItSetsQueryAndClientOnConstruct()
    {
        $this->assertNotNull($this->client->client);
        $this->assertEquals($this->query, $this->client->query);
    }
}
