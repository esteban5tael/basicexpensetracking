<?php

namespace App\Filament\Resources\CashMovements\Pages;


use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CashMovements\CashMovementResource;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class ListCashMovements extends ListRecords
{
    use HasFiltersForm;

    protected static string $resource = CashMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
