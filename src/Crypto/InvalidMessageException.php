<?php
namespace SamBurns\ThisIsBud\Crypto;

use Throwable;

class InvalidMessageException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponseBody(string $responseBody): InvalidMessageException
    {
        return new static('Expected JSON with "cell" and "block" fields, got: ' . var_export($responseBody, true));
    }
}
