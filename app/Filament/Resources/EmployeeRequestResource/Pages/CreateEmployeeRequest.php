<?php

namespace App\Filament\Resources\EmployeeRequestResource\Pages;

use App\Filament\Resources\EmployeeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployeeRequest extends CreateRecord
{
    protected static string $resource = EmployeeRequestResource::class;
}
