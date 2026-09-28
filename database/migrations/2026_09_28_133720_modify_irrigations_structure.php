<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finca_irrigation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finca_id')->constrained()->cascadeOnDelete();
            $table->foreignId('irrigation_id')->constrained()->cascadeOnDelete();
        });

        Schema::table('irrigations', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
        });

        $irrigations = DB::table('irrigations')->get();
        
        foreach ($irrigations as $irrigation) {
            if ($irrigation->finca_id) {
                $finca = DB::table('fincas')->where('id', $irrigation->finca_id)->first();
                
                if ($finca) {
                    DB::table('finca_irrigation')->insert([
                        'finca_id' => $finca->id,
                        'irrigation_id' => $irrigation->id,
                    ]);
                    
                    DB::table('irrigations')
                        ->where('id', $irrigation->id)
                        ->update(['user_id' => $finca->user_id]);
                }
            }
        }

        Schema::table('irrigations', function (Blueprint $table) {
            $table->dropForeign(['finca_id']);
            $table->dropColumn('finca_id');
        });
    }
};