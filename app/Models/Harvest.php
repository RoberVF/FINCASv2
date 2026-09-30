<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    protected $fillable = [
        'finca_id',
        'date',
        'quantity_kg',
        'sale_price',
        'observations'
    ];

    public function finca()
    {
        return $this->belongsTo(Finca::class);
    }
}
