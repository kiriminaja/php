<p align="center">
<img src="https://user-images.githubusercontent.com/39618526/209768908-54509816-d5d5-427e-bb01-05649ad8604a.png"/>
</p>

<h2 align="center">Develop. Connect. Shipped. #BantuMenujuLebihMaju.</h2>
  <p align="center">This library is the abstraction of KiriminAja API for access from applications written with PHP.
</p>

<h4 align="center">
  <a href="https://developer.kiriminaja.com">Documentation</a>
  <span> · </span>
  <a href="mailto:tech@kiriminaja.com">Contact Us</a>
</h4>

<p align="center">
<a href="https://packagist.org/packages/kiriminaja/kiriminaja-php"><img src="https://img.shields.io/packagist/dt/kiriminaja/kiriminaja-php" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/kiriminaja/kiriminaja-php"><img src="https://img.shields.io/packagist/v/kiriminaja/kiriminaja-php" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/kiriminaja/kiriminaja-php"><img src="https://img.shields.io/packagist/l/kiriminaja/kiriminaja-php" alt="License"></a>
</p>


## Installation

Install `kiriminaja-php` with composer by following command:

```bash
composer require kiriminaja/kiriminaja-php
```
or add it manually in your composer.json file.

## Usage
Configure package with your account's secret key obtained from KiriminAja Document Assignment.
```php
$mode = 'production' ? Mode::Production : Mode::Staging;

KiriminAjaConfig::setMode($mode)::setApiTokenKey('YOUR_KEY');
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
