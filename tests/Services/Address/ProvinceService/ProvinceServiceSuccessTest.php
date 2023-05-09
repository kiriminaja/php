<?php

namespace KiriminAja\Services\Address\ProvinceService;

require_once(__DIR__ .'/../AddressMock.php');

use KiriminAja\Repositories\AddressRepository;
use KiriminAja\Services\Address\AddressMock;
use KiriminAja\Services\Address\ProvinceService;
use PHPUnit\Framework\TestCase;

class ProvinceServiceSuccessTest extends TestCase {

    protected function setUp(): void {
        parent::setUp();
        $this->setMock();
    }

    private function setMock() {
        (new AddressMock())->addressMock()->shouldReceive('provinces')->andReturn($this->mockProvinces());
    }

    private function mockProvinces(): array {
        return [true, [
            "status" => true,
            "method" => "provinsis",
            "text" => "Berhasil",
            "datas" => [
                ["id" => 1, "provinsi_name" => "Bali"],
                ["id" => 2, "provinsi_name" => "Bangka Belitung"],
                ["id" => 3, "provinsi_name" => "Banten"],
                ["id" => 4, "provinsi_name" => "Bengkulu"],
                ["id" => 5, "provinsi_name" => "DI Yogyakarta"],
                ["id" => 6, "provinsi_name" => "DKI Jakarta"],
                ["id" => 7, "provinsi_name" => "Gorontalo"],
                ["id" => 8, "provinsi_name" => "Jambi"],
                ["id" => 9, "provinsi_name" => "Jawa Barat"],
                ["id" => 10, "provinsi_name" => "Jawa Tengah"],
                ["id" => 11, "provinsi_name" => "Jawa Timur"],
                ["id" => 12, "provinsi_name" => "Kalimantan Barat"],
                ["id" => 13, "provinsi_name" => "Kalimantan Selatan"],
                ["id" => 14, "provinsi_name" => "Kalimantan Tengah"],
                ["id" => 15, "provinsi_name" => "Kalimantan Timur"],
                ["id" => 16, "provinsi_name" => "Kalimantan Utara"],
                ["id" => 17, "provinsi_name" => "Kepulauan Riau"],
                ["id" => 18, "provinsi_name" => "Lampung"],
                ["id" => 19, "provinsi_name" => "Maluku"],
                ["id" => 20, "provinsi_name" => "Maluku Utara"],
                ["id" => 21, "provinsi_name" => "Nanggroe Aceh Darussalam (NAD)"],
                ["id" => 22, "provinsi_name" => "Nusa Tenggara Barat (NTB)"],
                ["id" => 23, "provinsi_name" => "Nusa Tenggara Timur (NTT)"],
                ["id" => 24, "provinsi_name" => "Papua"],
                ["id" => 25, "provinsi_name" => "Papua Barat"],
                ["id" => 26, "provinsi_name" => "Riau"],
                ["id" => 27, "provinsi_name" => "Sulawesi Barat"],
                ["id" => 28, "provinsi_name" => "Sulawesi Selatan"],
                ["id" => 29, "provinsi_name" => "Sulawesi Tengah"],
                ["id" => 30, "provinsi_name" => "Sulawesi Tenggara"],
                ["id" => 31, "provinsi_name" => "Sulawesi Utara"],
                ["id" => 32, "provinsi_name" => "Sumatera Barat"],
                ["id" => 33, "provinsi_name" => "Sumatera Selatan"],
                ["id" => 34, "provinsi_name" => "Sumatera Utara"],
            ],
        ]];
    }

    public function testSuccess() {
        \Mockery::close();

        \Mockery::mock("overload:".AddressRepository::class)
            ->shouldReceive([
                "provinces" => $this->mockProvinces()
            ]);

        $result = (new ProvinceService)->call();

        self::assertTrue($result->status);
        self::assertEquals("loaded", $result->message);
        self::assertIsArray($result->data);
    }

}
