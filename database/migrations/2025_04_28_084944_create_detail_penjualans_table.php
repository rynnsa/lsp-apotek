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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->foreign('id_penjualan')->references('id')->on('penjualans')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_obat');
            $table->foreign('id_obat')->references('id')->on('obats')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('jumlah_beli'); 
            $table->double('harga_beli'); 
            $table->integer('subtotal');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
