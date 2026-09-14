<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'finca_id',
        'date',
        'product',
        'dose',
        'cost',
        'notes'
    ];
}
