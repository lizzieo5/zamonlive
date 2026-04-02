<?php

namespace App\Filament\Resources\Newspapers\Pages;

use App\Filament\Resources\Newspapers\NewspaperResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewspapers extends ListRecords
{
    protected static string $resource = NewspaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
