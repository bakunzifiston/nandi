<?php

namespace App\Filament\Resources\FinishedGoodResource\Pages;

use App\Filament\Resources\FinishedGoodResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFinishedGood extends ViewRecord
{
    protected static string $resource = FinishedGoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
