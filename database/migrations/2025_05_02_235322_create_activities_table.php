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
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_aktivitas'); 
            $table->enum('jenis_aktivitas', ['lab', 'pre-test', 'demo', 'praktikum', 'lainnya']); 
            $table->timestamp('deadline'); 
            $table->text('deskripsi'); 
            $table->date('tanggal'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities'); 
    }
};
