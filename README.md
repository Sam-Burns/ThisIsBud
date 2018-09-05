# Bud Code Kata

## Running Tests

PHP 7.2 is needed, and Composer must be run first with `composer install`.

Tests are in `test/` and `spec/`. They can be run with the commands given below.

Unit tests for message decryption:
```bash
./vendor/bin/phpspec run
```

Integration tests for API client:
```bash
./vendor/bin/phpunit
```

## Application Architecture

The Oauth2 integration uses `league/oauth2-client`. It is in `src/Oauth2`.

The decryption service for translating the text of the API response is in `src/Crypto`.

The main service used to access the API is in `src/ApiClient`.

`src/Application/ContainerBuilder` and `config/di.php` contain the DI config. The container used is Pimple.

When `composer install` is run, `config/config.php` will be created, from the contents of `config/config.php.dist`.
