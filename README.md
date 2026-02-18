# KiriminAja API SDK
This library is the abstraction of KiriminAja API for access from applications written with PHP.

<a href="https://packagist.org/packages/kiriminaja/kiriminaja-php"><img src="https://img.shields.io/packagist/dt/kiriminaja/kiriminaja-php" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/kiriminaja/kiriminaja-php"><img src="https://img.shields.io/packagist/v/kiriminaja/kiriminaja-php" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/kiriminaja/kiriminaja-php"><img src="https://img.shields.io/packagist/l/kiriminaja/kiriminaja-php" alt="License"></a>


## Getting Started
### Requirements
PHP 8.0 and later

### Installation

Install `kiriminaja-php` with composer by following command:

```bash
composer require kiriminaja/kiriminaja-php
```
or add it manually in your composer.json file.

### Usage
Configure package with your account's secret key obtained from KiriminAja Document Assignment.
```php
$mode = 'production' ? Mode::Production : Mode::Staging;

// Optional: configure cache directory (useful if /tmp is not writable)
KiriminAjaConfig::setCacheDirectory(__DIR__ . '/kiriminaja-cache');
// Or disable caching entirely:
// KiriminAjaConfig::disableCache();

KiriminAjaConfig::setMode($mode)::setApiTokenKey('YOUR_KEY');
```
You can read our test case for the examples https://github.com/kiriminaja/php/blob/main/tests/Services/Shipping/RequestPickupService/RequestPickupServiceSuccessTest.php

### Contributing

For any requests, bugs, or comments, please open an [issue](https://github.com/kiriminaja/kiriminaja-php/issues) or [submit a pull request](https://github.com/kiriminaja/kiriminaja-php/pulls).

### Installing Packages

Before you start to code, run this command to install all of the required packages. Make sure you have `composer` installed in your computer

```bash
composer install
```

### Tests

#### Running test suite:

```bash
vendor\bin\phpunit tests
```
