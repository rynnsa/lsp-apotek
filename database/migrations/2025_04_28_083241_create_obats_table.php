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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat', 100)->unique();
            $table->unsignedBigInteger('id_jenis'); 
            $table->foreign('id_jenis')->references('id')->on('jenis_obats')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('harga_jual');
            $table->text('deskripsi_obat');
            $table->string('foto1');
            $table->string('foto2')->nullable();
            $table->string('foto3')->nullable();
            $table->integer('stok');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
