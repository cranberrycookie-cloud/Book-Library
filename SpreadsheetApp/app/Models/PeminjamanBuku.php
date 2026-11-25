<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    protected $table = 'peminjaman_bukus';

    protected $fillable = [
        'gmail_peminjam',
        'nama_peminjam',
        'judul_buku',
        'isbn',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'cover_url',
        'jumlah_buku',
        'tanggal_pinjam',
        'durasi_hari',
        'tanggal_kembali',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];
}