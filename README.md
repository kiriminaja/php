# KiriminAja API Client Library

This library is the abstraction of KiriminAja API for access from applications written with PHP.

## Documentation

For the API documentation, check [KiriminAja API Documentation](https://developer.kiriminaja.com).

## Installation

Install `kiriminaja-php` with composer by following command:

```bash
composer require kiriminaja/kiriminaja-php
```
or add it manually in your composer.json file.

## Usage
Configure package with your account's secret key obtained from KiriminAja Document Assignment.
```php
KiriminAja::setApiKey('YOUR_KEY');
```
