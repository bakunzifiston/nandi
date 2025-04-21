<?php

namespace App\Filament\Resources\SalesDistributionResource\Pages;

use App\Filament\Resources\SalesDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesDistribution extends EditRecord
{
    protected static string $resource = SalesDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
