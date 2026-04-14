<?php

/**
 * KiriminAja PHP SDK — Playground
 *
 * A lightweight router that exposes every SDK endpoint for quick manual testing.
 * Uses PHP's built-in web server — no framework required.
 *
 * Usage:
 *   cd example
 *   composer install
 *   KIRIMINAJA_API_KEY=your_key php -S localhost:3000 index.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use KiriminAja\Base\Config\KiriminAjaConfig;
use KiriminAja\Base\Config\Cache\Mode;
use KiriminAja\Services\KiriminAja;

// ---------------------------------------------------------------------------
// Config
// ---------------------------------------------------------------------------
$apiKey = getenv('KIRIMINAJA_API_KEY') ?: ($_ENV['KIRIMINAJA_API_KEY'] ?? '');
if ($apiKey === '') {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'KIRIMINAJA_API_KEY environment variable is not set']);
    exit;
}

KiriminAjaConfig::setMode(Mode::Staging)::setApiTokenKey($apiKey);

// ---------------------------------------------------------------------------
// Router
// ---------------------------------------------------------------------------
$method = $_SERVER['REQUEST_METHOD'];
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

header('Content-Type: application/json');

// Simple pattern matcher: /path/:param
function matchRoute(string $pattern, string $path): ?array
{
    $patternParts = explode('/', trim($pattern, '/'));
    $pathParts    = explode('/', trim($path, '/'));

    if (count($patternParts) !== count($pathParts)) return null;

    $params = [];
    foreach ($patternParts as $i => $part) {
        if (str_starts_with($part, ':')) {
            $params[substr($part, 1)] = $pathParts[$i];
        } elseif ($part !== $pathParts[$i]) {
            return null;
        }
    }
    return $params;
}

try {
    // -----------------------------------------------------------------------
    // GET /
    // -----------------------------------------------------------------------
    if ($method === 'GET' && $path === '/') {
        echo json_encode([
            'name'   => 'KiriminAja PHP SDK Playground',
            'routes' => [
                'GET  /'                            => 'List all routes',
                'GET  /provinces'                   => 'List all provinces',
                'GET  /cities/:province_id'         => 'Cities in a province',
                'GET  /districts/:city_id'          => 'Districts in a city',
                'GET  /sub-districts/:district_id'  => 'Sub-districts in a district',
                'GET  /districts-by-name/:search'   => 'Search districts by name',
                'GET  /couriers'                    => 'List available couriers',
                'GET  /couriers/group'              => 'Courier groups',
                'GET  /couriers/:code'              => 'Courier detail',
                'GET  /schedules'                   => 'Pickup schedules',
                'GET  /tracking/:order_id'          => 'Track express order',
                'GET  /instant/tracking/:order_id'  => 'Track instant order',
                'GET  /payment/:payment_id'         => 'Get payment details',
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    // -----------------------------------------------------------------------
    // Address
    // -----------------------------------------------------------------------
    if ($method === 'GET' && $path === '/provinces') {
        echo json_encode(toArray(KiriminAja::getProvince()));
        exit;
    }

    if ($method === 'GET' && ($p = matchRoute('/cities/:id', $path))) {
        echo json_encode(toArray(KiriminAja::getCity((int) $p['id'])));
        exit;
    }

    if ($method === 'GET' && ($p = matchRoute('/districts/:id', $path))) {
        echo json_encode(toArray(KiriminAja::getDistrict((int) $p['id'])));
        exit;
    }

    if ($method === 'GET' && ($p = matchRoute('/sub-districts/:id', $path))) {
        echo json_encode(toArray(KiriminAja::getSubDistrict((int) $p['id'])));
        exit;
    }

    if ($method === 'GET' && ($p = matchRoute('/districts-by-name/:search', $path))) {
        echo json_encode(toArray(KiriminAja::getDistrictByName($p['search'])));
        exit;
    }

    // -----------------------------------------------------------------------
    // Courier
    // -----------------------------------------------------------------------
    if ($method === 'GET' && $path === '/couriers') {
        echo json_encode(toArray(KiriminAja::getCouriers()));
        exit;
    }

    if ($method === 'GET' && $path === '/couriers/group') {
        echo json_encode(toArray(KiriminAja::getCourierGroups()));
        exit;
    }

    if ($method === 'GET' && ($p = matchRoute('/couriers/:code', $path))) {
        echo json_encode(toArray(KiriminAja::getCourierDetail($p['code'])));
        exit;
    }

    // -----------------------------------------------------------------------
    // Schedules
    // -----------------------------------------------------------------------
    if ($method === 'GET' && $path === '/schedules') {
        echo json_encode(toArray(KiriminAja::getSchedules()));
        exit;
    }

    // -----------------------------------------------------------------------
    // Tracking
    // -----------------------------------------------------------------------
    if ($method === 'GET' && ($p = matchRoute('/tracking/:order_id', $path))) {
        echo json_encode(toArray(KiriminAja::getTracking($p['order_id'])));
        exit;
    }

    if ($method === 'GET' && ($p = matchRoute('/instant/tracking/:order_id', $path))) {
        echo json_encode(toArray(KiriminAja::getTrackingInstant($p['order_id'])));
        exit;
    }

    // -----------------------------------------------------------------------
    // Payment
    // -----------------------------------------------------------------------
    if ($method === 'GET' && ($p = matchRoute('/payment/:payment_id', $path))) {
        echo json_encode(toArray(KiriminAja::getPayment($p['payment_id'])));
        exit;
    }

    // -----------------------------------------------------------------------
    // 404
    // -----------------------------------------------------------------------
    http_response_code(404);
    echo json_encode(['error' => 'Not found', 'path' => $path]);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error'   => $e->getMessage(),
        'file'    => basename($e->getFile()),
        'line'    => $e->getLine(),
    ]);
}

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------
function toArray($response): array
{
    return [
        'status'  => $response->status,
        'message' => $response->message,
        'data'    => $response->data,
    ];
}
