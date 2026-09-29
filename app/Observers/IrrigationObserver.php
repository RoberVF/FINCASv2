<?php

namespace App\Observers;

use App\Models\Irrigation;
use App\Models\Tank;
use App\Models\WaterMovement;
use App\Enums\WaterMovementType;

class IrrigationObserver
{
    public function saving(Irrigation $irrigation): void
    {
        if ($irrigation->tank_id) {
            $tank = Tank::find($irrigation->tank_id);
            if ($tank) {
                $irrigation->cost = $irrigation->quantity * $tank->current_average_price;
            }
        }
    }

    public function saved(Irrigation $irrigation): void
    {
        if ($irrigation->tank_id) {
            WaterMovement::updateOrCreate(
                ['irrigation_id' => $irrigation->id],
                [
                    'tank_id' => $irrigation->tank_id,
                    'type' => WaterMovementType::RIEGO,
                    'quantity' => $irrigation->quantity,
                    'total_cost' => 0,
                    'date' => $irrigation->date,
                    'description' => 'Salida automática por riego'
                ]
            );
        } else {
            WaterMovement::where('irrigation_id', $irrigation->id)->delete();
        }
    }

    public function deleted(Irrigation $irrigation): void
    {
        WaterMovement::where('irrigation_id', $irrigation->id)->delete();
    }
}