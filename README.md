# KiriminAja API Client Library

This library is the abstraction of KiriminAja API for access from applications written with PHP.

## Documentation

For the API documentation, check [KiriminAja API Documentation](https://developer.kiriminaja.com). Contact us by sending an email to
- [tech@kiriminaja.com](mailto:tech@kiriminaja.com)

## Installation

Install `kiriminaja-php` with composer by following command:

```bash
composer require kiriminaja/kiriminaja-php
```
or add it manually in your composer.json file.

## Usage
Configure package with your account's secret key obtained from KiriminAja Document Assignment.
```php
KiriminAjaConfig::setApiTokenKey('YOUR_KEY');
```

## Available Services
```php
KiriminAja::getCity((int) $province_id);
KiriminAja::getDistrict((int) $district_id);
KiriminAja::getDistrictByName((string) $keyword);
KiriminAja::getProvince();
KiriminAja::setWhiteListExpedition((array) $services);
KiriminAja::setCallback((string) $url);
KiriminAja::getPrice(ShippingPriceData $data);
KiriminAja::getSchedules();
KiriminAja::requestPickup(RequestPickupData $data);
KiriminAja::getPayment((string) $payment_id);
KiriminAja::cancelShipment((string) $waybill,(string)  $reason);
KiriminAja::getTracking((string) $package_id);
KiriminAja::getSchedules();
```

## Contributing

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

#### Running examples:

```bash
php examples\InvoiceExample.php
```

There is a pre-commit hook to run phpcs and phpcbf. Please make sure they passed before making commits/pushes.
