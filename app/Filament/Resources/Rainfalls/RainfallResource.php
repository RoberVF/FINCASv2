<?php

namespace App\Filament\Resources\Rainfalls;

use App\Filament\Resources\Rainfalls\Pages\CreateRainfall;
use App\Filament\Resources\Rainfalls\Pages\EditRainfall;
use App\Filament\Resources\Rainfalls\Pages\ListRainfalls;
use App\Filament\Resources\Rainfalls\Schemas\RainfallForm;
use App\Filament\Resources\Rainfalls\Tables\RainfallsTable;
use App\Models\Rainfall;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RainfallResource extends Resource
{
    protected static ?string $model = Rainfall::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCloud;
    protected static ?string $modelLabel = 'Lluvia';
    protected static ?string $pluralModelLabel = 'Lluvias';
    protected static ?int $navigationSort = 10;

    protected static \UnitEnum|string|null $navigationGroup = 'Agua';


    public static function form(Schema $schema): Schema
    {
        return RainfallForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RainfallsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRainfalls::route('/'),
            'create' => CreateRainfall::route('/create'),
            'edit' => EditRainfall::route('/{record}/edit'),
        ];
    }
}
