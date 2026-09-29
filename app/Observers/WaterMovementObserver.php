<?php

namespace App\Observers;

use App\Models\WaterMovement;
use App\Enums\WaterMovementType;

class WaterMovementObserver
{
    public function saving(WaterMovement $movement): void
    {
        if ($movement->type === WaterMovementType::COMPRA) {
            $qty = abs($movement->quantity);
            if ($movement->price_per_pipa && ! $movement->total_cost) {
                $movement->total_cost = $qty * $movement->price_per_pipa;
            } elseif ($movement->total_cost && ! $movement->price_per_pipa && $qty > 0) {
                $movement->price_per_pipa = $movement->total_cost / $qty;
            }
        } else {
            $movement->price_per_pipa = 0;
            $movement->total_cost = 0;
        }

        if (in_array($movement->type, [WaterMovementType::COMPRA, WaterMovementType::LLUVIA, WaterMovementType::OTROS])) {
            $movement->quantity = abs($movement->quantity);
        } else {
            $movement->quantity = -abs($movement->quantity);
        }
    }

    public function saved(WaterMovement $movement): void
    {
        $movement->tank->recalculateBalances();
    }

    public function deleted(WaterMovement $movement): void
    {
        if ($movement->tank) {
            $movement->tank->recalculateBalances();
        }
    }
}