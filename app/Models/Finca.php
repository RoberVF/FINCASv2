<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{
    protected $fillable = [
        'user_id',
        'crop_id',
        'variety_id',
        'name',
        'location',
        'size_sqm'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class);
    }
}
