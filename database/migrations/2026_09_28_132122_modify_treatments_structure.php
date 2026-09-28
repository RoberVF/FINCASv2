<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finca_treatment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finca_id')->constrained()->cascadeOnDelete();
            $table->foreignId('treatment_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('treatments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
        });

        $treatments = DB::table('treatments')->get();
        
        foreach ($treatments as $treatment) {
            if ($treatment->finca_id) {
                $finca = DB::table('fincas')->where('id', $treatment->finca_id)->first();
                
                if ($finca) {
                    DB::table('finca_treatment')->insert([
                        'finca_id' => $finca->id,
                        'treatment_id' => $treatment->id,
                    ]);
                    
                    DB::table('treatments')
                        ->where('id', $treatment->id)
                        ->update(['user_id' => $finca->user_id]);
                }
            }
        }

        Schema::table('treatments', function (Blueprint $table) {
            $table->dropForeign(['finca_id']);
            $table->dropColumn('finca_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finca_treatment');
    }
};