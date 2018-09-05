<?php
namespace SamBurns\ThisIsBud\Oauth2\Oauth2Client;

use GuzzleHttp\ClientInterface;
use League\OAuth2\Client\Provider\GenericProvider;
use SamBurns\ThisIsBud\Oauth2\Oauth2Client;

class LeaguePhp implements Oauth2Client
{
    public function getAccessToken(ClientInterface $httpClient, string $clientId, string $clientSecret, string $domain): string
    {
        $options = [
            'urlAuthorize' => '​',
            'urlAccessToken' => $domain . '/Token',
            'urlResourceOwnerDetails' => '',
        ];

        $provider = new GenericProvider($options, ['httpClient' => $httpClient]);

        return $provider->getAccessToken(
            'client_credentials',
            [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]
        );
    }
}
