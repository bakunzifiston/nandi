<?php

namespace App\Filament\Resources\ProcessingProductionResource\Pages;

use App\Filament\Resources\ProcessingProductionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProcessingProduction extends ViewRecord
{
    protected static string $resource = ProcessingProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
