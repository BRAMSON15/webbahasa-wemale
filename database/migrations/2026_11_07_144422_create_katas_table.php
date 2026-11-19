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
        Schema::create('katas', function (Blueprint $table) {
            $table->id();
            $table->string('kata_wemale');
            $table->text('arti_indonesia');
            $table->text('contoh')->nullable();
            $table->text('terjemahan_contoh')->nullable();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
            $table->boolean('is_populer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katas');
    }
};
