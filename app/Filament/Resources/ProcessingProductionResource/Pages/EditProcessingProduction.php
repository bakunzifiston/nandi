<?php

namespace App\Filament\Resources\ProcessingProductionResource\Pages;

use App\Filament\Resources\ProcessingProductionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcessingProduction extends EditRecord
{
    protected static string $resource = ProcessingProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
