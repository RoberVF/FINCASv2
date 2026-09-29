<?php

namespace App\Filament\Resources\Irrigations;

use App\Filament\Resources\Irrigations\Pages\CreateIrrigation;
use App\Filament\Resources\Irrigations\Pages\EditIrrigation;
use App\Filament\Resources\Irrigations\Pages\ListIrrigations;
use App\Filament\Resources\Irrigations\Schemas\IrrigationForm;
use App\Filament\Resources\Irrigations\Tables\IrrigationsTable;
use App\Models\Irrigation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IrrigationResource extends Resource
{
    protected static ?string $model = Irrigation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFunnel;

    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Riegos';
    protected static ?string $pluralLabel = 'Riegos';

    protected static \UnitEnum|string|null $navigationGroup = 'Agua';


    public static function form(Schema $schema): Schema
    {
        return IrrigationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IrrigationsTable::configure($table);
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
            'index' => ListIrrigations::route('/'),
            'create' => CreateIrrigation::route('/create'),
            'edit' => EditIrrigation::route('/{record}/edit'),
        ];
    }
}
