<?php

namespace KiriminAja\Services\Shipping\TrackingService;

use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Services\Shipping\TrackingService;
use Mockery;
use PHPUnit\Framework\TestCase;

class TrackingServiceSuccessTest extends TestCase
{
    public function test()
    {
        $this->tearDown();
        $expect = (object) [
            "status_code" => 200,
            "details" => (object) [
                "awb" => "DEVEL-000000004",
                "order_id" => "OID-8793949106",
                "status_code" => null,
                "estimation" => "-",
                "service" => "jne",
                "service_name" => "REG",
                "drop" => false,
                "shipped_at" => "2021-07-13 17:44:04",
                "delivered" => true,
                "delivered_at" => "2021-10-17 16:53:00",
                "refunded" => false,
                "refunded_at" => "",
                "images" => (object) [
                    "camera_img" => "https://s3-ap-southeast-1.amazonaws.com/pod.paket.id/1626253243482P||1411922100004643.jpeg",
                    "signature_img" => "https://s3-ap-southeast-1.amazonaws.com/pod.paket.id/1626253255242S||1411922100004643.jpeg",
                    "pop_img" => null
                ],
                "costs" => (object) [
                    "add_cost" => 0,
                    "currency" => "IDR",
                    "cod" => 0,
                    "insurance_amount" => 0,
                    "insurance_percent" => 0,
                    "discount_amount" => 0,
                    "subsidi_amount" => 0,
                    "shipping_cost" => 10000,
                    "correction" => 0
                ],
                "origin" => (object) [
                    "name" => "KiriminAja",
                    "address" => "Jl. Utara Stadion No.8, Jetis, Wedomartani",
                    "phone" => "628000000",
                    "city" => "Kabupaten Sleman",
                    "zip_code" => "55283"
                ],
                "destination" => (object) [
                    "name" => "Zainal Arifin",
                    "address" => "Ngaglik RT. 32 Pendowoharjo Sewon Bantul Yogyakarta 55185",
                    "phone" => "6287839087416",
                    "city" => "Kabupaten Bantul",
                    "zip_code" => "55715"
                ]
            ],
            "histories" => array(
                (object) [
                    "created_at" => "2021-07-14 16:00:00",
                    "status" => "Delivered to BAGUS | 14-07-2021 16:00 | YOGYAKARTA ",
                    "status_code" => 200,
                    "driver" => "",
                    "receiver" => "BAGUS"
                ]
            )
        ];

        Mockery::mock("overload:".ShippingRepository::class)->shouldReceive([
                'tracking' => [
                    true,
                    [
                        'status'      => true,
                        'text'        => 'Delivered to BAGUS | 14-07-2021 16:00 | YOGYAKARTA',
                        'status_code' => 200,
                        'details'     => $expect->details,
                        'histories'   => $expect->histories
                    ]
                ]
        ]);

        $order_id = 'OID-MOCK123';
        $result = (new TrackingService($order_id))->call();

        self::assertTrue($result->status);
        self::assertEquals('Delivered to BAGUS | 14-07-2021 16:00 | YOGYAKARTA', $result->message);
        self::assertEquals(200, $result->data['status_code']);
        self::assertEquals($expect->details, $result->data['details']);
        self::assertEquals($expect->histories, $result->data['histories']);
    }
}
