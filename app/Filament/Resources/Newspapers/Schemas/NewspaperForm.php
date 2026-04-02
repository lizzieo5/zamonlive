<?php

namespace App\Filament\Resources\Newspapers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NewspaperForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Sarlavha')
                    ->required(),
                FileUpload::make('file')
                    ->label('PDF fayl')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('newspapers')
                    ->disk('public')
                    ->openable()
                    ->downloadable()
                    ->previewable(false),
            ]);
    }
}
