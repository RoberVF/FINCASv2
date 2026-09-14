<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $fillable = ['name', 'description'];

    public function varieties()
    {
        return $this->hasMany(Variety::class);
    }
}
