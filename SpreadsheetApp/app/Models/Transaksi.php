<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $primaryKey = 'id_transaksi';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id_transaksi',
        'time',
        'namaBarang',
        'kuantitas',
        'isbn',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jumlah_tersedia',
        'jumlah_dipinjam',
    ];
}
