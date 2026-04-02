<?php

namespace App\Filament\Resources\Newspapers\Pages;

use App\Filament\Resources\Newspapers\NewspaperResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNewspaper extends CreateRecord
{
    protected static string $resource = NewspaperResource::class;
}
