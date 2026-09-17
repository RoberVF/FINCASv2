<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $fillable = ['name', 'user_id', 'description'];

    protected static function booted(): void
    {
        static::addGlobalScope('user_id', function ($builder) {
            if (auth()->check() && !auth()->user()->is_admin) {
                $builder->where('user_id', auth()->id());
            }
        });

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    public function varieties()
    {
        return $this->hasMany(Variety::class);
    }
}
