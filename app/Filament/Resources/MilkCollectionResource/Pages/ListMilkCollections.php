<?php

namespace App\Filament\Resources\MilkCollectionResource\Pages;

use App\Filament\Resources\MilkCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMilkCollections extends ListRecords
{
    protected static string $resource = MilkCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
