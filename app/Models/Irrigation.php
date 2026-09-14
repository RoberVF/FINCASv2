<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Irrigation extends Model
{
    protected $fillable = [
        'finca_id',
        'date',
        'water_volume',
        'duration',
        'notes'
    ];
}
