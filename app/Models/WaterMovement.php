<?php

namespace App\Models;

use App\Enums\WaterMovementType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'tank_id', 'irrigation_id', 'type', 'quantity', 
        'price_per_pipa', 'total_cost', 'date', 'description'
    ];

    protected $casts = [
        'type' => WaterMovementType::class,
        'date' => 'date',
    ];

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }

    public function irrigation()
    {
        return $this->belongsTo(Irrigation::class);
    }
}