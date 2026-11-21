<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $novel = [
            ['NOV001', '2026-11-01 09:00:00', 'Bumi', 95000, 3],
            ['NOV002', '2026-11-02 10:15:00', 'Bulan', 98000, 2],
            ['NOV003', '2026-11-03 11:30:00', 'Matahari', 105000, 4],
            ['NOV004', '2026-11-04 13:00:00', 'Hujan', 89000, 2],
            ['NOV005', '2026-11-05 14:20:00', 'Pembunuhan di Orient Express', 85000, 3],
            ['NOV006', '2026-11-06 15:10:00', 'Dan Tidak Ada Lagi', 78000, 2],
            ['NOV007', '2026-11-07 16:00:00', 'Pembunuhan Roger Ackroyd', 82000, 1],
            ['NOV008', '2026-11-08 09:30:00', 'A Study in Scarlet', 75000, 2],
            ['NOV009', '2026-11-09 10:45:00', 'The Hound of the Baskervilles', 88000, 3],
            ['NOV010', '2026-11-10 13:15:00', 'The Adventures of Sherlock Holmes', 92000, 2],
        ];

        foreach ($novel as $data) {
            DB::table('transaksis')->updateOrInsert(
                ['id_transaksi' => $data[0]],
                [
                    'time' => $data[1],
                    'namaBarang' => $data[2],
                    'hargaBarang' => $data[3],
                    'kuantitas' => $data[4],
                ]
            );
        }
    }
}
