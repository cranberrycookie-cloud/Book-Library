<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {

            $table->string('isbn', 20)
                ->nullable()
                ->unique()
                ->after('id_transaksi');

            $table->string('pengarang')
                ->nullable()
                ->after('namaBarang');

            $table->string('penerbit')
                ->nullable()
                ->after('pengarang');

            $table->unsignedSmallInteger('tahun_terbit')
                ->nullable()
                ->after('penerbit');

            $table->unsignedInteger('jumlah_tersedia')
                ->default(0)
                ->after('kuantitas');

            $table->unsignedInteger('jumlah_dipinjam')
                ->default(0)
                ->after('jumlah_tersedia');

        });

        // Memindahkan kuantitas lama menjadi jumlah tersedia.
        // Jumlah dipinjam dimulai dari 0.

        DB::table('transaksis')->update([

            'jumlah_tersedia' => DB::raw('COALESCE(kuantitas, 0)'),

            'jumlah_dipinjam' => 0,

        ]);
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {

            $table->dropUnique(['isbn']);

            $table->dropColumn([
                'isbn',
                'pengarang',
                'penerbit',
                'tahun_terbit',
                'jumlah_tersedia',
                'jumlah_dipinjam'
            ]);

        });
    }
};