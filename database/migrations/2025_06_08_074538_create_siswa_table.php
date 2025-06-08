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
        Schema::create('siswa', function (Blueprint $table) {
            $table->ulid('id_siswa')->primary();
            $table->foreignUlid('id_kota')->nullable();
            $table->string('nis', 10)->unique();
            $table->string('nama_siswa');
            $table->date('tgl_lahir');
            $table->enum('gender', ['L', 'P']);
            $table->text('alamat');
            $table->foreign('id_kota')->references('id_kota')->on('kota')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
