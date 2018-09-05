<?php
namespace SamBurns\ThisIsBud\Application;

class Config
{
    private const OPTIONS_FILE = __DIR__ . '/../../config/config.php';

    private $options;

    private function getOptions(): array
    {
        if (!$this->options) {

            if (!file_exists(static::OPTIONS_FILE)) {
                throw new \Exception('File at ' . static::OPTIONS_FILE . ' should have been created during Composer install, but was not found.');
            }
            $this->options = include static::OPTIONS_FILE;
        }

        return $this->options;
    }

    public function getClientId(): string
    {
        return $this->getOptions()['client_id'];
    }

    public function getClientSecret(): string
    {
        return $this->getOptions()['client_secret'];
    }

    public function getApiDomain(): string
    {
        return $this->getOptions()['api_domain'];
    }
}
