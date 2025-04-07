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
        $package1 = new PackageData();
        $package1->order_id = "PYH-12312312X";
        $package1->destination_name = "Alice Smith";
        $package1->destination_phone = "081123456789";
        $package1->destination_address = "Jl. Lainnya No. 789";
        $package1->destination_kecamatan_id = 789;
        $package1->weight = 300;
        $package1->width = 5;
        $package1->height = 5;
        $package1->length = 5;
        $package1->item_value = 5000;
        $package1->shipping_cost = 10000;
        $package1->service = "anteraja";
        $package1->service_type = "REG";
        $package1->item_name = "Produk Lain";
        $package1->package_type_id = 1;
        $package1->cod = 0;
        $package1->note = 'Hallo';

        $payload = new RequestPickupData();
        $payload->address = 'Jl. Example No.123, Indonesia';
        $payload->phone = '081234567890';
        $payload->name = 'John Doe';
        $payload->zipcode = '12345';
        $payload->kecamatan_id = 1010;
        $payload->schedule = '2025-05-01 10:00:00';
        $payload->platform_name = 'MyPlatform';
        $payload->latitude = -6.200000;
        $payload->longitude = 106.816666;
        $payload->packages->add($package1);
        
        $resp = KiriminAja::requestPickup($payload);
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
