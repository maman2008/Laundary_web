<?php

namespace App\Filament\Resources\EmployeeRequestResource\Pages;

use App\Filament\Resources\EmployeeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeRequests extends ListRecords
{
    protected static string $resource = EmployeeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
