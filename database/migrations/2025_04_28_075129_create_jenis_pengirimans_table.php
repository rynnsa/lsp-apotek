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
        Schema::create('jenis_pengirimans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kirim', ['ekonomi', 'kargo', 'reguler', 'same day', 'standard']);
            $table->string('nama_expedisi')->nullable();
            $table->string('logo_expedisi')->nullable();
            $table->integer('ongkos_kirim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pengirimans');
    }
};
