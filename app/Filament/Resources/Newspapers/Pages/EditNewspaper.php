<?php

namespace App\Filament\Resources\Newspapers\Pages;

use App\Filament\Resources\Newspapers\NewspaperResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNewspaper extends EditRecord
{
    protected static string $resource = NewspaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
