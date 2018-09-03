<?php

namespace SamBurns\ThisIsBud\Crypto;

class MessageDecryptionService
{
    public function decrypt(JsonMessage $inputJson): JsonMessage
    {
        $cyphertextCell = $inputJson->getCell();
        $plaintextCell = $this->decryptString($cyphertextCell);

        $cyphertextBlock = $inputJson->getBlock();
        $plaintextBlock = $this->decryptString($cyphertextBlock);

        return JsonMessage::fromCellAndBlock($plaintextCell, $plaintextBlock);
    }

    private function decryptString(string $cyphertext): string
    {
        $cyphertextCharacters = explode(' ', $cyphertext);

        $decryptCharacter = function (string $droidspeakCharacter): string {
            return chr(bindec($droidspeakCharacter));
        };

        $plaintextCharacters = array_map($decryptCharacter, $cyphertextCharacters);

        return implode('', $plaintextCharacters);
    }
}
