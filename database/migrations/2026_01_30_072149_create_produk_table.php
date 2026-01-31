<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->integer('id_produk')->primary();
            $table->string('nama_produk');
            $table->integer('harga');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('status_id');

            $table->foreign('kategori_id')
                ->references('id_kategori')
                ->on('kategori');

            $table->foreign('status_id')
                ->references('id_status')
                ->on('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
