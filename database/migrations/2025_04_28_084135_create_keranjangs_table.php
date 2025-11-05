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
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pelanggan'); 
            $table->foreign('id_pelanggan')->references('id')->on('pelanggans')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_obat'); 
            $table->foreign('id_obat')->references('id')->on('obats')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->double('jumlah_order');
            $table->double('harga');
            $table->double('subtotal');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};
