<?php

namespace App\Filament\Resources\Newspapers;

use App\Filament\Resources\Newspapers\Pages\CreateNewspaper;
use App\Filament\Resources\Newspapers\Pages\EditNewspaper;
use App\Filament\Resources\Newspapers\Pages\ListNewspapers;
use App\Filament\Resources\Newspapers\Schemas\NewspaperForm;
use App\Filament\Resources\Newspapers\Tables\NewspapersTable;
use App\Models\Newspaper;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NewspaperResource extends Resource
{
    protected static ?string $model = Newspaper::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowDown;

    protected static ?string $navigationLabel = 'Gazetalar';

    protected static string|\UnitEnum|null $navigationGroup = 'Nashrlar';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return NewspaperForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewspapersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewspapers::route('/'),
            'create' => CreateNewspaper::route('/create'),
            'edit' => EditNewspaper::route('/{record}/edit'),
        ];
    }
}
