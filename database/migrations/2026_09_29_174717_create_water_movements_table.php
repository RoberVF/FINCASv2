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
        Schema::create('water_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tank_id')->constrained()->cascadeOnDelete();
            $table->foreignId('irrigation_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->decimal('quantity', 10, 2);
            $table->decimal('price_per_pipa', 10, 4)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_movements');
    }
};
