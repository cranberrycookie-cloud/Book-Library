<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_bukus', function (Blueprint $table) {
            $table->id();
            $table->string('gmail_peminjam')->index();
            $table->string('nama_peminjam');
            $table->string('judul_buku');
            $table->string('isbn')->nullable();
            $table->string('pengarang')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('tahun_terbit', 10)->nullable();
            $table->text('cover_url')->nullable();
            $table->unsignedInteger('jumlah_buku')->default(1);
            $table->date('tanggal_pinjam');
            $table->unsignedInteger('durasi_hari')->default(7);
            $table->date('tanggal_kembali');
            $table->string('catatan')->nullable();
            $table->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_bukus');
    }
};