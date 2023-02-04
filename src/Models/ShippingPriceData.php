<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class ShippingPriceData extends ModelBase {
    // int	false	ID dari kecamatan_id pengirim
    public int $origin;
    // int	false	ID dari kecamatan_id customer
    public int $destination;
    // int	false	Akumulasi berat paket dalam gram (berat paket aktual). Jika berat dimensi lebih besar dari berat aktual paket maka yang dikirimkan adalah berat dimensi
    public int $weight;
    // int	true	Diisi jika paket membutuhkan asuransi (1 true, 0 false)
    public ?int $insurance = null;
    // int	true	Wajib diisi jika insurance diisi. Atau diisi untuk menghitung biaya COD dari paket (jika COD)
    public ?int $item_value = null;
    // string or array	true	Untuk mengetahui list kurir silahkan hubungi kami
    public $courier;
}
