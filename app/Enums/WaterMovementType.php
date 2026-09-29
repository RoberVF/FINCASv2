<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum WaterMovementType: string implements HasLabel, HasColor
{
    case COMPRA = 'compra';
    case LLUVIA = 'lluvia';
    case OTROS = 'otros';
    case MERMA = 'merma';
    case RIEGO = 'riego';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::COMPRA => 'Compra',
            self::LLUVIA => 'Lluvia',
            self::OTROS => 'Otros (Regalo/Traspaso)',
            self::MERMA => 'Merma / Ajuste',
            self::RIEGO => 'Salida por Riego',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::COMPRA => 'warning', // Naranja (Cuesta dinero)
            self::LLUVIA => 'info',    // Azul
            self::OTROS => 'success',  // Verde (Gratis)
            self::MERMA => 'danger',   // Rojo (Pérdida)
            self::RIEGO => 'primary',  // Azul principal
        };
    }
}