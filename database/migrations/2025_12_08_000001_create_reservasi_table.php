<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penyewa')->nullable();
            $table->foreign('id_penyewa')->references('id_penyewa')->on('penyewa')->onDelete('set null');
            $table->foreignId('id_user')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tgl_checkin')->nullable();
            $table->date('tgl_checkout')->nullable();
            $table->integer('jumlah_tamu')->default(1);
            $table->string('status_reservasi')->default('pending');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->decimal('dp', 12, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
