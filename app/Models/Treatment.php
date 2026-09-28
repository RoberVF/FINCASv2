<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Treatment extends Model
{
    protected $fillable = [
        'user_id',
        'finca_id',
        'date',
        'product',
        'dose',
        'cost',
        'notes'
    ];

    public function fincas(): BelongsToMany
    {
        return $this->belongsToMany(Finca::class);
    }

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
}
