<?php
namespace SamBurns\ThisIsBud\Test;

use PHPUnit\Framework\TestCase;
use SamBurns\ThisIsBud\ApiClient\ApiClientService;
use SamBurns\ThisIsBud\Application\Config;
use SamBurns\ThisIsBud\Application\ContainerBuilder;

class ConfigTest extends TestCase
{
    public function testDiConfig()
    {
        $container = (new ContainerBuilder())->buildContainer();
        $apiClientService = $container['api-client-service'];
        $this->assertInstanceOf(ApiClientService::class, $apiClientService);
    }

    public function testApplicationConfig()
    {
        $path = __DIR__ . '/../config/config.php';

        $this->assertTrue(file_exists($path), 'Config file should have been created during Composer install');

        $config = new Config();
        $this->assertInternalType('string' , $config->getClientId());
        $this->assertInternalType('string' , $config->getClientSecret());
        $this->assertInternalType('string' , $config->getApiDomain());
    }
}
