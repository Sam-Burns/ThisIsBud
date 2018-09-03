<?php

namespace spec\SamBurns\ThisIsBud\Crypto;

use SamBurns\ThisIsBud\Crypto\JsonMessage;
use PhpSpec\ObjectBehavior;

class MessageDecryptionServiceSpec extends ObjectBehavior
{
    function it_decrypts_single_character_messages()
    {
        $inputJsonMessage = JsonMessage::fromJsonString('{"cell": "01000001", "block": "01000010"}');
        $expectedOutput = JsonMessage::fromJsonString('{"cell": "A", "block": "B"}');
        $this->decrypt($inputJsonMessage)->shouldBeLike($expectedOutput);
    }

    function it_decrypts_longer_messages()
    {
        $inputJsonMessage = JsonMessage::fromJsonString('{"cell": "01000001 01000010", "block": "01000011 01000100"}');
        $expectedOutput = JsonMessage::fromJsonString('{"cell": "AB", "block": "CD"}');
        $this->decrypt($inputJsonMessage)->shouldBeLike($expectedOutput);
    }
}
