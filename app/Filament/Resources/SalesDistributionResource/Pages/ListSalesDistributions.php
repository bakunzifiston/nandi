<?php

namespace App\Filament\Resources\SalesDistributionResource\Pages;

use App\Filament\Resources\SalesDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesDistributions extends ListRecords
{
    protected static string $resource = SalesDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
