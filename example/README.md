# Playground

A zero-dependency playground that exposes the KiriminAja PHP SDK endpoints for quick manual testing using PHP's built-in web server.

## Setup

```bash
cd example
composer install
```

## Run

```bash
KIRIMINAJA_API_KEY=your_key php -S localhost:3000 index.php
```

The server starts at `http://localhost:3000`. Visit `/` to see all available routes.

## Available Routes

| Route                              | Description                 |
| ---------------------------------- | --------------------------- |
| `GET /`                            | List all routes             |
| `GET /provinces`                   | List all provinces          |
| `GET /cities/:province_id`         | Cities in a province        |
| `GET /districts/:city_id`          | Districts in a city         |
| `GET /sub-districts/:district_id`  | Sub-districts in a district |
| `GET /districts-by-name/:search`   | Search districts by name    |
| `GET /couriers`                    | List available couriers     |
| `GET /couriers/group`              | Courier groups              |
| `GET /couriers/:code`              | Courier detail              |
| `GET /schedules`                   | Pickup schedules            |
| `GET /tracking/:order_id`          | Track express order         |
| `GET /instant/tracking/:order_id`  | Track instant order         |
| `GET /payment/:payment_id`         | Get payment details         |
