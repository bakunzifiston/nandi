<?php

namespace App\Filament\Resources\MilkCollectionResource\Pages;

use App\Filament\Resources\MilkCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMilkCollection extends EditRecord
{
    protected static string $resource = MilkCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
