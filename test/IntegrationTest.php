<?php
namespace SamBurns\ThisIsBud\Test;

use PHPUnit\Framework\TestCase;
use SamBurns\ThisIsBud\ApiClient\ApiClientService;
use SamBurns\ThisIsBud\Application\ContainerBuilder;

class IntegrationTest extends TestCase
{
    /** @var ApiClientService */
    private $apiClientService;

    /** @var SpyHttpClient */
    private $stubHttpClient;

    public function setUp()
    {
        $container = (new ContainerBuilder())->buildContainer();

        $this->stubHttpClient = new SpyHttpClient();
        $container['http-client'] = $this->stubHttpClient;

        $this->apiClientService = $container['api-client-service'];
    }

    public function testOauth2Integration()
    {
        $this->apiClientService->retrieveData();

        $oauth2Request = $this->stubHttpClient->getRequestsReceived()[0];

        $this->assertEquals('POST', $oauth2Request->getMethod());
        $this->assertEquals(['application/x-www-form-urlencoded'], $oauth2Request->getHeader('content-type'));
        $this->assertEquals(
            'client_id=clientid&client_secret=clientsecret&grant_type=client_credentials',
            $oauth2Request->getBody()->getContents()
        );
    }

    public function testReactorExhaustDeletion()
    {
        $this->apiClientService->retrieveData();

        $exhaustRequest = $this->stubHttpClient->getRequestsReceived()[1];

        $this->assertEquals('DELETE', $exhaustRequest->getMethod());
        $this->assertEquals(['application/json'], $exhaustRequest->getHeader('Content-Type'));
        $this->assertEquals(['Bearer e31a726c4b90462ccb7619e1b51f3d0068bf8006'], $exhaustRequest->getHeader('Authorization'));
        $this->assertEquals(['2'], $exhaustRequest->getHeader('x-torpedoes'));
    }

    public function testGettingLeia()
    {
        $this->apiClientService->retrieveData();

        $exhaustRequest = $this->stubHttpClient->getRequestsReceived()[2];

        $this->assertEquals('GET', $exhaustRequest->getMethod());
        $this->assertEquals(['application/json'], $exhaustRequest->getHeader('Content-Type'));
        $this->assertEquals(['Bearer e31a726c4b90462ccb7619e1b51f3d0068bf8006'], $exhaustRequest->getHeader('Authorization'));
    }

    public function testResponseDecryption()
    {
        $response = $this->apiClientService->retrieveData();
        $this->assertEquals('Detention Block AA-23,', $response->getBlock());
        $this->assertEquals('Cell 2187', $response->getCell());
    }
}
