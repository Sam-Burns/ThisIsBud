<?php

namespace spec\SamBurns\ThisIsBud\Crypto;

use PhpSpec\ObjectBehavior;
use SamBurns\ThisIsBud\Crypto\InvalidMessageException;
use SamBurns\ThisIsBud\Crypto\JsonMessage;

class JsonMessageSpec extends ObjectBehavior
{
    function it_can_be_constructed_from_a_json_string()
    {
        $this->beConstructedThrough('fromJsonString', ['{"cell": "01000001", "block": "01000010"}']);
        $this->getCell()->shouldBe('01000001');
        $this->getBlock()->shouldBe('01000010');
    }

    function it_can_be_constructed_from_a_cell_and_block()
    {
        $this->beConstructedThrough('fromCellAndBlock', ['A', 'B']);
        $this->getCell()->shouldBe('A');
        $this->getBlock()->shouldBe('B');
    }

    function it_can_be_converted_to_json()
    {
        $this->beConstructedThrough('fromJsonString', ['{"cell": "A", "block": "B"}']);

        $expectedJson = <<<JSON
{
    "cell": "A",
    "block": "B"
}
JSON;

        $this->getJsonString()->shouldBe($expectedJson);
    }

    function it_validates_the_json()
    {
        $this->beConstructedThrough('fromJsonString', ['']);
        $this->shouldThrow(InvalidMessageException::class)->duringInstantiation();

        $this->beConstructedThrough('fromJsonString', ['{"cell": "01000001"}']);
        $this->shouldThrow(InvalidMessageException::class)->duringInstantiation();

        $this->beConstructedThrough('fromJsonString', ['{"block": "01000010"}']);
        $this->shouldThrow(InvalidMessageException::class)->duringInstantiation();

        $this->beConstructedThrough('fromJsonString', ['{"cell": "{"cell": "01000001", "block": "01000010"}"}']);
        $this->shouldBeAnInstanceOf(JsonMessage::class);
    }
}
