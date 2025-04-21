<?php

namespace App\Filament\Resources\MilkCollectionResource\Pages;

use App\Filament\Resources\MilkCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMilkCollection extends ViewRecord
{
    protected static string $resource = MilkCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
