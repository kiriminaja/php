<p align="center">
<img src="https://user-images.githubusercontent.com/39618526/209768908-54509816-d5d5-427e-bb01-05649ad8604a.png"/>
</p>

<h2 align="center">Develop. Connect. Shipped. Tenang Pakai #KiriminAja.</h2>
  <p align="center">This library is the abstraction of KiriminAja API for access from applications written with PHP.
</p>

<h4 align="center">
  <a href="https://developer.kiriminaja.com">Documentation</a>
  <span> · </span>
  <a href="mailto:tech@kiriminaja.com">Contact Us</a>
  <span> · </span>
  <a href="https://instagram.com/kiriminaja.it">Fun IG Account</a>
  <span> · </span>
  <a href="https://developer.kiriminaja.com/blog">Blog</a>
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
// When on your dev/stag 
KiriminAjaConfig::setMode(Mode::Staging)::setApiTokenKey('YOUR_KEY');

// When on your production
KiriminAjaConfig::setMode(Mode::Production)::setApiTokenKey('YOUR_KEY');
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
KiriminAja::requestPickup(RequestPickupData $data);
KiriminAja::getPayment((string) $payment_id);
KiriminAja::cancelShipment((string) $waybill,(string)  $reason);
KiriminAja::getTracking((string) $package_id);
KiriminAja::getSchedules();
```

## Get Price Example
```php
public function get_price() {
    $shipping_price_object = new ShippingPriceData;
    $shipping_price_object->origin = 1063;
    $shipping_price_object->destination = 1064;
    $shipping_price_object->weight = 1000;
    $shipping_price_object->insurance = 1;
    $shipping_price_object->item_value = 100000;
    $shipping_price_object->courier = ['jne', 'jnt', 'sicepat'];
    return KiriminAja::getPrice($shipping_price_object);
}
```

## Request Pickup Example
```php
public function request_pickup() {
    $pickup_object = new RequestPickupData;
    $pickup_object->address = "Jl. Jodipati No.29 Perum Taman Kencana Sejahtera";
    $pickup_object->phone = "082129627860";
    $pickup_object->name = "dipaferdian";
    $pickup_object->kecamatan_id = 5784;
    $pickup_object->schedule = "2022-11-03 17:00:00";
    $pickup_object->zipcode = 16610;
    $pickup_object->platform_name = 'mitra';
    // Array of packages
    $pickup_object->packages = [];

    // Package object
    $package_data = new PackageData;
    $package_data->order_id = "DEV-2300000024";
    $package_data->destination_name = "Flag Test3";
    $package_data->destination_phone = "082223323333";
    $package_data->destination_address = "Jl. Magelang KM 11";
    $package_data->destination_kecamatan_id = 419;
    $package_data->destination_zipcode = 55598;
    $package_data->weight = 520;
    $package_data->width = 8;
    $package_data->height = 8;
    $package_data->length = 8;
    $package_data->item_value = 275000;
    $package_data->shipping_cost = 65000;
    $package_data->service = "sicepat";
    $package_data->service_type = "SIUNT";
    $package_data->item_name = "Test item name";
    $package_data->package_type_id = 1;
    $package_data->cod = 0;
    $package_data->note = 'test pickup request non cod';
    $package_data->drop = true;
    
    // Bind package object to packages
    $pickup_object->packages = [$package_data];
    
    return KiriminAja::requestPickup($pickup_object);
}
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
