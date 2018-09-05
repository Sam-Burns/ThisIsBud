<?php
namespace SamBurns\ThisIsBud\ApiClient;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use SamBurns\ThisIsBud\Application\Config;
use SamBurns\ThisIsBud\Crypto\JsonMessage;
use SamBurns\ThisIsBud\Crypto\MessageDecryptionService;
use SamBurns\ThisIsBud\Oauth2\Oauth2Client;

class ApiClientService
{
    private $messageDecryptionService;
    private $httpClient;
    private $oauth2Client;
    private $config;

    public function __construct(
        Oauth2Client $oauth2Client,
        ClientInterface $client,
        MessageDecryptionService $messageDecryptionService,
        Config $config
    ) {
        $this->messageDecryptionService = $messageDecryptionService;
        $this->httpClient = $client;
        $this->oauth2Client = $oauth2Client;
        $this->config = $config;
    }

    public function retrieveData(): JsonMessage
    {
        $accessToken = $this->getToken();
        $this->deleteExhausts($accessToken);
        $leiaResponse = $this->getLeia($accessToken);

        $responseJson = JsonMessage::fromJsonString($leiaResponse);

        return $this->messageDecryptionService->decrypt($responseJson);
    }

    private function getToken(): string
    {
        return $this->oauth2Client->getAccessToken(
            $this->httpClient,
            $this->config->getClientId(),
            $this->config->getClientSecret(),
            $this->config->getApiDomain()
        );
    }

    private function deleteExhausts(string $accessToken)
    {
        $request = new Request(
            'DELETE',
            $this->config->getApiDomain() . '/reactor/exhaust/1',
            [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'x-torpedoes' => '2',
            ]
        );

        $this->httpClient->send($request);
    }

    private function getLeia(string $accessToken): string
    {
        $request = new Request(
            'GET',
            $this->config->getApiDomain() . '/prisoner/leia',
            [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ]
        );

        $response = $this->httpClient->send($request);
        $response->getBody()->rewind();

        return $response->getBody()->getContents();
    }
}
