<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Category;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->helperText('Leave empty to auto-generate from title'),
                Textarea::make('body')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('thumbnail')
                    ->image()
                    ->directory('news')
                    ->imageEditor(),
                Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable()
                    ->native(false),
            ]);
    }
}
