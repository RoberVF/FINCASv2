<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'capacity',
        'current_volume',
        'current_average_price',
        'location',
        'material',
        'is_roofed',
        'notes'
    ];

    protected $casts = [
        'is_roofed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(WaterMovement::class);
    }

    public function recalculateBalances()
    {
        $movements = $this->movements()->orderBy('date')->orderBy('id')->get();

        $volume = 0;
        $pmp = 0;

        foreach ($movements as $mov) {
            $qty = abs($mov->quantity);

            if (in_array($mov->type, [\App\Enums\WaterMovementType::COMPRA, \App\Enums\WaterMovementType::LLUVIA, \App\Enums\WaterMovementType::OTROS])) {
                $cost = $mov->total_cost ?? 0;

                if ($volume < 0) {
                    $pmp = $qty > 0 ? ($cost / $qty) : $pmp;
                } else {
                    if ($volume + $qty > 0) {
                        $pmp = (($volume * $pmp) + $cost) / ($volume + $qty);
                    }
                }
                $volume += $qty;
            } else {
                $volume -= $qty;
            }
        }

        \Illuminate\Support\Facades\DB::table('tanks')->where('id', $this->id)->update([
            'current_volume' => $volume,
            'current_average_price' => $pmp,
        ]);
    }
}
