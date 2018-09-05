<?php

use GuzzleHttp\Client;
use Pimple\Container;
use SamBurns\ThisIsBud\ApiClient\ApiClientService;
use SamBurns\ThisIsBud\Application\Config;
use SamBurns\ThisIsBud\Crypto\MessageDecryptionService;
use SamBurns\ThisIsBud\Oauth2\Oauth2Client\LeaguePhp;

return [

    'message-decryption-service' => function (Container $container) {
        return new MessageDecryptionService();
    },

    'api-client-service'  => function (Container $container) {

        $oauth2Client = new LeaguePhp();
        $httpClient = $container['http-client'];
        $messageDecryptionService = $container['message-decryption-service'];
        $config = new Config();

        return new ApiClientService($oauth2Client, $httpClient, $messageDecryptionService, $config);
    },

    'http-client' => function (Container $container) {
        return new Client();
    },

];
