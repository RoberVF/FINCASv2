<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('user_fincas', function (Builder $builder) {
                if (!auth()->user()->is_admin) {
                    $builder->where('user_id', auth()->id());
                }
            });
        }

        static::creating(function ($finca) {
            if (auth()->check() && empty($finca->user_id)) {
                $finca->user_id = auth()->id();
            }
        });
    }

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

    public function irrigations()
    {
        return $this->hasMany(Irrigation::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public function harvests()
    {
        return $this->hasMany(Harvest::class);
    }
}
