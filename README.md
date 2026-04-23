# KiriminAja PHP SDK

[![Total Downloads](https://img.shields.io/packagist/dt/kiriminaja/kiriminaja-php)](https://packagist.org/packages/kiriminaja/kiriminaja-php)
[![Latest Stable Version](https://img.shields.io/packagist/v/kiriminaja/kiriminaja-php)](https://packagist.org/packages/kiriminaja/kiriminaja-php)
[![license](https://img.shields.io/packagist/l/kiriminaja/kiriminaja-php)](LICENSE)

Official PHP SDK for the [KiriminAja](https://kiriminaja.com) logistics API.

## Requirements

- PHP 8.1+
- ext-json

## Installation

```bash
composer require kiriminaja/kiriminaja-php
```

---

## Quick Start

Call `KiriminAjaConfig` once at app startup, then call any service method on the `KiriminAja` facade.

```php
use KiriminAja\Base\Config\KiriminAjaConfig;
use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Services\KiriminAja;

KiriminAjaConfig::setMode(Mode::Staging)::setApiTokenKey('YOUR_API_KEY');

// Use any service
$provinces = KiriminAja::getProvince();
```

---

## Config Options

| Method                                       | Description                                             |
| -------------------------------------------- | ------------------------------------------------------- |
| `KiriminAjaConfig::setMode($mode)`           | `Mode::Staging` or `Mode::Production`                   |
| `KiriminAjaConfig::setApiTokenKey($key)`     | Your KiriminAja API key                                 |
| `KiriminAjaConfig::setBaseUrl($url)`         | Custom base URL (useful for proxy or self-hosted)       |
| `KiriminAjaConfig::setCacheDirectory($path)` | Custom cache directory (useful if /tmp is not writable) |
| `KiriminAjaConfig::disableCache()`           | Disable file-based caching entirely                     |

```php
// Custom cache directory
KiriminAjaConfig::setCacheDirectory(__DIR__ . '/kiriminaja-cache');

// Or disable caching entirely
KiriminAjaConfig::disableCache();

KiriminAjaConfig::setMode(Mode::Production)::setApiTokenKey('YOUR_API_KEY');
```

### Custom Base URL

If you need to route requests through a proxy or custom endpoint, set a custom base URL. This overrides the default URL resolved from the mode.

```php
KiriminAjaConfig::setMode(Mode::Production)
    ::setApiTokenKey('YOUR_API_KEY')
    ::setBaseUrl('https://proxy.example.com');
```

---

## Laravel Integration

The SDK auto-registers via Laravel package discovery — no manual provider registration needed.

### 1. Add to `config/services.php`

```php
'kiriminaja' => [
    'mode' => env('KIRIMINAJA_MODE', 'staging'),
    'api_key' => env('KIRIMINAJA_API_KEY', ''),
    'base_url' => env('KIRIMINAJA_BASE_URL'),
    'cache_store' => env('KIRIMINAJA_CACHE_STORE', 'laravel'),
    'cache_prefix' => env('KIRIMINAJA_CACHE_PREFIX', 'kiriminaja:'),
],
```

### 2. Add to your `.env`

```env
KIRIMINAJA_MODE=staging
KIRIMINAJA_API_KEY=your-api-key-here
```

### 3. Use the SDK anywhere

```php
use KiriminAja\Services\KiriminAja;

$provinces = KiriminAja::getProvince();
```

### Config Reference (`services.kiriminaja`)

| Key            | Env Variable              | Default       | Description                                           |
| -------------- | ------------------------- | ------------- | ----------------------------------------------------- |
| `mode`         | `KIRIMINAJA_MODE`         | `staging`     | `staging` or `production`                             |
| `api_key`      | `KIRIMINAJA_API_KEY`      | `""`          | Your KiriminAja API key                               |
| `base_url`     | `KIRIMINAJA_BASE_URL`     | `null`        | Custom base URL (overrides mode-based URL)            |
| `cache_store`  | `KIRIMINAJA_CACHE_STORE`  | `laravel`     | `laravel` (uses Laravel Cache) or `file` (file-based) |
| `cache_prefix` | `KIRIMINAJA_CACHE_PREFIX` | `kiriminaja:` | Cache key prefix (Laravel store only)                 |

---

## CodeIgniter 4 Integration

CodeIgniter 4 doesn't auto-discover Composer packages, so you wire the SDK up once during boot.

### 1. Publish the config

Create `app/Config/KiriminAja.php`:

```php
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use KiriminAja\Base\Config\Cache\Mode;

class KiriminAja extends BaseConfig
{
    public string $mode = Mode::Staging;          // or Mode::Production
    public string $apiKey = '';
    public ?string $baseUrl = null;
    public string $cacheStore = 'codeigniter';    // or 'file'
    public string $cachePrefix = 'kiriminaja:';
}
```

### 2. Bootstrap from `app/Config/Events.php`

```php
use CodeIgniter\Events\Events;
use KiriminAja\CodeIgniter\KiriminAjaBootstrap;
use Config\Services;

Events::on('pre_system', static function () {
    KiriminAjaBootstrap::boot(config('KiriminAja'), Services::cache());
});
```

### 3. Use the SDK anywhere

```php
use KiriminAja\Services\KiriminAja;

$provinces = KiriminAja::getProvince();
```

### Config Reference (`Config\KiriminAja`)

| Property      | Default         | Description                                                       |
| ------------- | --------------- | ----------------------------------------------------------------- |
| `mode`        | `staging`       | `staging` or `production`                                         |
| `apiKey`      | `""`            | Your KiriminAja API key                                           |
| `baseUrl`     | `null`          | Custom base URL (overrides mode-based URL)                        |
| `cacheStore`  | `codeigniter`   | `codeigniter` (uses CI4 cache service) or `file` (file-based)     |
| `cachePrefix` | `kiriminaja:`   | Cache key prefix (codeigniter store only)                         |

> The bootstrap helper also accepts a plain associative array — handy for tests
> or non-conventional setups: `KiriminAjaBootstrap::boot(['mode' => 'staging', 'api_key' => '...'], $cache);`

---

## Services

### Address

```php
// List all provinces
KiriminAja::getProvince();

// Cities in a province (province_id)
KiriminAja::getCity(5);

// Districts in a city (city_id)
KiriminAja::getDistrict(12);

// Sub-districts in a district (kecamatan_id)
KiriminAja::getSubDistrict(77);

// Search districts by name
KiriminAja::getDistrictByName("jakarta");
```

---

### Coverage Area & Pricing

```php
use KiriminAja\Models\ShippingPriceData;
use KiriminAja\Models\ShippingPriceInstantData;
use KiriminAja\Models\ShippingFullPriceData;

// Express shipping rates
$data = new ShippingPriceData();
$data->origin = 1;
$data->destination = 2;
$data->weight = 1000;       // grams
$data->item_value = 50000;
$data->insurance = 0;
$data->courier = ['jne', 'jnt'];

KiriminAja::getPrice($data);

// Instant (same-day) rates
$data = new ShippingPriceInstantData();
$data->service = ['grab_express', 'gosend'];
$data->item_price = 10000;
$data->origin = ['lat' => -6.2, 'long' => 106.8, 'address' => 'Jl. Sudirman No.1'];
$data->destination = ['lat' => -6.21, 'long' => 106.81, 'address' => 'Jl. Thamrin No.5'];
$data->weight = 1000;
$data->vehicle = 'motor';       // 'motor' or 'mobil'
$data->timezone = 'Asia/Jakarta';

KiriminAja::getPriceInstant($data);

// Full shipping price (all available couriers)
$data = new ShippingFullPriceData();
$data->origin = 1;
$data->destination = 2;
$data->weight = 1000;

KiriminAja::fullShippingPrice($data);
```

---

### Order — Express

```php
use KiriminAja\Models\RequestPickupData;
use KiriminAja\Models\PackageData;
use KiriminAja\Models\PackageItemData;
use KiriminAja\Models\PackageItemMetadata;

// Track by order ID
KiriminAja::getTracking("ORDER123");

// Cancel shipment
KiriminAja::cancelShipment("AWB123456", "Customer request");

// Request pickup
$pickup = new RequestPickupData();
$pickup->address = "Jl. Jodipati No.29";
$pickup->phone = "08133345678";
$pickup->name = "Tokotries";
$pickup->kecamatan_id = 548;
$pickup->schedule = "2024-01-15 17:00:00";
$pickup->platform_name = "mitra";

$package = new PackageData();
$package->order_id = "YGL-000000019";
$package->destination_name = "Flag Test";
$package->destination_phone = "082223323333";
$package->destination_address = "Jl. Magelang KM 11";
$package->destination_kecamatan_id = 548;
$package->weight = 520;
$package->width = 8;
$package->height = 8;
$package->length = 8;
$package->item_value = 275000;
$package->shipping_cost = 65000;
$package->service = "jne";
$package->service_type = "REG";
$package->item_name = "Test item";
$package->package_type_id = 1;
$package->cod = 0;

// `items` is optional. When provided, it lists the individual items
// contained in the package. `item_value` is still required.
$item = new PackageItemData();
$item->name = "Kaos Polos";
$item->price = 125000;
$item->qty = 2;
$item->weight = 260;
$item->width = 4;
$item->length = 4;
$item->height = 4;
$item->metadata = new PackageItemMetadata();
$item->metadata->sku = "KP-001";
$item->metadata->variant_label = "Merah / L";
$package->items = [$item];

$pickup->packages->add($package);
KiriminAja::requestPickup($pickup);

// Pickup schedules
KiriminAja::getSchedules();
```

---

### Order — Instant

```php
use KiriminAja\Models\RequestPickupInstantData;
use KiriminAja\Models\PackageInstantData;

// Request instant pickup
$pickup = new RequestPickupInstantData();
$pickup->service = "gosend";
$pickup->service_type = "instant";
$pickup->vehicle = "motor";
$pickup->order_prefix = "BDI";

$package = new PackageInstantData();
$package->origin_name = "Rizky";
$package->origin_phone = "081280045616";
$package->origin_lat = -7.854584;
$package->origin_long = 110.331154;
$package->origin_address = "Wirobrajan, Yogyakarta";
$package->origin_address_note = "Dekat Kantor";
$package->destination_name = "Okka";
$package->destination_phone = "081280045616";
$package->destination_lat = -7.776192;
$package->destination_long = 110.325053;
$package->destination_address = "Godean, Sleman";
$package->destination_address_note = "Dekat Pasar";
$package->shipping_price = 34000;
$package->item_name = "Barang 1";
$package->item_description = "Barang 1 Description";
$package->item_price = 20000;
$package->item_weight = 1000;     // grams

KiriminAja::requestPickupInstant($pickup, $package);

// Track instant order
KiriminAja::getTrackingInstant("ORDER123");

// Find a new driver for an existing order
KiriminAja::findNewDriver("ORDER123");

// Cancel instant order
KiriminAja::cancelShipment("ORDER123", "", isInstant: true);
```

---

### Courier

```php
// List available couriers
KiriminAja::getCouriers();

// Courier groups
KiriminAja::getCourierGroups();

// Courier detail by code
KiriminAja::getCourierDetail("jne");

// Set whitelist expeditions
KiriminAja::setWhiteListExpedition(["jne_reg", "jne_yes"]);
```

---

### Credit

```php
// Get the current KiriminAja credit balance
$result = KiriminAja::getCreditBalance();
// $result->data['balance'] => int
```

---

### Preference

```php
// Set callback URL
KiriminAja::setCallback("https://example.com/webhook");
```

---

### Pickup Schedules

```php
KiriminAja::getSchedules();
```

---

### Payment

```php
// Get payment details (express)
KiriminAja::getPayment("PAY123");

// Get payment details (instant)
KiriminAja::getPayment("PAY123", isInstant: true);
```

---

## Contributing

For any requests, bugs, or comments, please open an [issue](https://github.com/kiriminaja/kiriminaja-php/issues) or [submit a pull request](https://github.com/kiriminaja/kiriminaja-php/pulls).

## Development

```bash
composer install           # install dependencies
vendor/bin/phpunit tests   # run tests
# or `make test`
```
