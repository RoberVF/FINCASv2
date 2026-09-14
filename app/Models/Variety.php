<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    protected $fillable = ['crop_id', 'name', 'description'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
