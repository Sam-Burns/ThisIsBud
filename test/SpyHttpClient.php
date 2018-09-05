<?php
namespace SamBurns\ThisIsBud\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SpyHttpClient extends Client
{
    /** @var ResponseInterface[] */
    private $response;

    /** @var RequestInterface[] */
    private $request = [];

    public function __construct()
    {
        parent::__construct();

        $this->response = [
            'POST' => $this->getOauth2Response(),
            'DELETE' => $this->getExhaustResponse(),
            'GET' => $this->getLeiaResponse(),
        ];
    }

    public function reset()
    {
        $this->request = [];
    }

    /**
     * @return RequestInterface[]
     */
    public function getRequestsReceived(): array
    {
        return $this->request;
    }

    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        $this->request[] = $request;
        $method = $request->getMethod();
        $response = $this->response[$method];

        return $response;
    }

    private function getOauth2Response()
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            '{
                "access_token": "e31a726c4b90462ccb7619e1b51f3d0068bf8006",
                "expires_in": 99999999999,
                "token_type": "Bearer",
                "scope": "TheForce"
            }');
    }

    private function getExhaustResponse()
    {
        return new Response();
    }

    private function getLeiaResponse()
    {
        return new Response(
            200,
            [],
            '{
                "cell": "01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111",
                "block": "01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 01101110 00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001 00101101 00110010 00110011 00101100"
            }'
        );
    }
}
