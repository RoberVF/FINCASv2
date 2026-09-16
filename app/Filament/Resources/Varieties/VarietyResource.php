<?php

namespace App\Filament\Resources\Varieties;

use App\Filament\Resources\Varieties\Pages\CreateVariety;
use App\Filament\Resources\Varieties\Pages\EditVariety;
use App\Filament\Resources\Varieties\Pages\ListVarieties;
use App\Filament\Resources\Varieties\Schemas\VarietyForm;
use App\Filament\Resources\Varieties\Tables\VarietiesTable;
use App\Models\Variety;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VarietyResource extends Resource
{
    protected static ?string $model = Variety::class;

    protected static ?string $modelLabel = 'Variedad';
    protected static ?string $pluralModelLabel = 'Variedades';
    protected static ?string $navigationLabel = 'Variedades';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function form(Schema $schema): Schema
    {
        return VarietyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VarietiesTable::configure($table);
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
            'index' => ListVarieties::route('/'),
            'create' => CreateVariety::route('/create'),
            'edit' => EditVariety::route('/{record}/edit'),
        ];
    }
}
