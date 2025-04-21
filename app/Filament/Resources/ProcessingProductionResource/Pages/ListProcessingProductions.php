<?php

namespace App\Filament\Resources\ProcessingProductionResource\Pages;

use App\Filament\Resources\ProcessingProductionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcessingProductions extends ListRecords
{
    protected static string $resource = ProcessingProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
