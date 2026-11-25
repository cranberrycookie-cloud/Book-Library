<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman_bukus', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjaman_bukus', 'gmail_peminjam')) {
                $table->string('gmail_peminjam')->nullable()->index();
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'nama_peminjam')) {
                $table->string('nama_peminjam')->nullable();
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'judul_buku')) {
                $table->string('judul_buku')->nullable();
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'jumlah_buku')) {
                $table->unsignedInteger('jumlah_buku')->default(1);
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'tanggal_pinjam')) {
                $table->date('tanggal_pinjam')->nullable();
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'durasi_hari')) {
                $table->unsignedInteger('durasi_hari')->default(7);
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'tanggal_kembali')) {
                $table->date('tanggal_kembali')->nullable();
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'catatan')) {
                $table->string('catatan')->nullable();
            }
            if (!Schema::hasColumn('peminjaman_bukus', 'status')) {
                $table->string('status')->default('Dipinjam');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman_bukus', function (Blueprint $table) {
            $columns = [
                'gmail_peminjam',
                'nama_peminjam',
                'judul_buku',
                'jumlah_buku',
                'tanggal_pinjam',
                'durasi_hari',
                'tanggal_kembali',
                'catatan',
                'status',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('peminjaman_bukus', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};