<?php

namespace KiriminAja\Models;

use KiriminAja\Base\ModelBase;

class PackageData extends ModelBase {

    public $order_id;                     //	string(max:20)	false	Order ID, harus memiliki prefix berupa string
    public $destination_name;             //	string(max:50)	false	Nama penerima
    public $destination_phone;            //	string(max:15)	false	Nomor telepon diawali dengan angka 0
    public $destination_address;          //	string(max:200,min:10)	false	Alamat penerima, kami menggunakan minimal 10 karakter untuk menghindari Bad Address pickup
    public $destination_kecamatan_id;     //	int	false	Kecamatan penerima
    public $weight;                       //	int(min:1)	false	Berat paket dalam gram
    public $width;                        //	int(min:1)	false	cm
    public $length;                       //	int(min:1)	false	cm
    public $qty;                          //	int	true	Jumlah barang dalam paket, akan terisi 1 jika kosong
    public $height;                       //	int(min:1)	false	cm
    public $item_value;                   //	int	false	Nilai barang secara keseluruhan
    public $shipping_cost;                //	int	false	Biaya pengiriman, see # Shipping Price section
    public $service;                      //	string	false	Lihat shipping price untuk ini
    public $insurance_amount = 0;         //	string	true	Lihat Syarat & Ketentuan
    public $service_type;                 //	string	false	The service type, like EZ, REG, CTC, OKE, etc (see shipping price section)
    public $cod;                          //	int	false	COD PRICE NB : Isi 0 untuk paket non COD
    public $package_type_id;              //	int	false	Tipe paket tersedia untuk sementara 1
    public $item_name;                    //	string(max:255)	false	Isi paket
    public $drop;                         //	bool	true	DROP-OFF / CASHLESS
    public $note;                         //	string(max:50)	true	Special instructions

}