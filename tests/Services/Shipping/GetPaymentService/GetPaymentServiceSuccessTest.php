<?php

namespace KiriminAja\Services\Shipping\GetPaymentService;

use KiriminAja\Repositories\ShippingRepository;
use KiriminAja\Services\Shipping\GetPaymentService;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetPaymentServiceSuccessTest extends TestCase
{

    public function test()
    {
        Mockery::close();
        $payment_object = (object) [
            "payment_id" => "XID-4875081955",
            "qr_content" => "00020101021226600016ID.CO.SHOPEE.WWW0118936009180001228938020712289380303UME51440014ID.CO.QRIS.WWW0215ID20210724181180303UME520453995303360540865000.005802ID5910KIRIMINAJA6011KAB. SLEMAN61055528162360520082022110311100323980708AA1606216304B823",
            "method" => "08",
            "pay_time" => "20221103111003",
            "status" => "Billing berhasil dibuat",
            "status_code" => "9",
            "amount" => 65000,
            "paid_at" => null,
            "created_at" => "2022-10-31T07:58:21.000000Z"
        ];

        Mockery::mock("overload:".ShippingRepository::class)
            ->shouldReceive([
                'payment' => [
                    true,
                    [
                        'status' => true,
                        'text'   => "Success get shipping payment data",
                        'data'   => $payment_object
                    ]
                ]
            ])->once();

        $payment_id = "XID-4875081955";
        $result = (new GetPaymentService($payment_id))->call();

        self::assertTrue($result->status);
        self::assertEquals('Success get shipping payment data', $result->message);
        self::assertEquals($payment_object, $result->data);
    }
}
