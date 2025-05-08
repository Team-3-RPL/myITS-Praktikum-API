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
            $table->string('name'); 
            $table->enum('activity_type', ['lab session', 'pre-test', 'demo', 'practicum']);
            $table->boolean('has_submission')->default(false);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();  
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('practicum_id')->constrained('practicums')->onDelete('cascade'); 
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
