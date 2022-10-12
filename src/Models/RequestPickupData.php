<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class RequestPickupData extends ModelBase {
    public $address;         // string(max:200)	false	Alamat lengkap
    public $phone;           // string(max:15)	false	Nomor telepon menggunakan format angka 0
    public $name;            // string(max:50)	false	Nama pengirim paket
    public $zipcode;         // string(max:5)	true	Kode pos pengirim
    public $kecamatan_id;    // integer	false	Kecamatan id pengirim
    public $packages;        // PackageData of array(min:1 object)	false	Lihat penyusunan list paket berikut
    public $schedule;        // string	false	Lihat bagian #Pickup Schedules
    public $platform_name;
}