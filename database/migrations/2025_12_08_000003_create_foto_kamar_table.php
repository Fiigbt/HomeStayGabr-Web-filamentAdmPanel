<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_kamar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kamar')->nullable()->constrained('kamar')->nullOnDelete();
            $table->string('url');
            $table->string('caption')->nullable();
            $table->boolean('is_cover')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_kamar');
    }
};
