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
        Schema::create('rainfalls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('zone');
            $table->date('date');
            $table->decimal('quantity_mm', 8, 2);
            $table->text('observations')->nullable();
            $table->timestamps();
        });

        Schema::create('finca_rainfall', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finca_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rainfall_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rainfalls');
    }
};
