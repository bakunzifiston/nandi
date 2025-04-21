<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MilkCollectionResource\Pages;
use App\Filament\Resources\MilkCollectionResource\RelationManagers;
use App\Models\MilkCollection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\TextColumn;

class MilkCollectionResource extends Resource
{
    protected static ?string $model = MilkCollection::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('farmer_id')
                    ->relationship('farmer', 'name')
                    ->required(),
                DateTimePicker::make('date_time')->required(),
                TextInput::make('quantity_collected')->numeric()->required(),
                Select::make('quality_check')
                    ->options([
                        'Accepted' => 'Accepted',
                        'Rejected' => 'Rejected',
                    ])->required(),
                TextInput::make('rejected_quantity')->numeric(),
                CheckboxList::make('rejection_reason')
    ->options([
        'organoleptic_fail' => 'Organoleptic test failed',
        'density_out_of_range' => 'Density out of range',
        'alcohol_fail' => 'Alcohol test failed',
        'antibiotics_positive' => 'Antibiotics detected',
        'clot_on_boiling_fail' => 'Clot on boiling failed',
        'temperature_out_of_range' => 'Temperature out of range',
        'aflatoxin_detected' => 'Aflatoxin M1 detected',
        'ph_out_of_range' => 'pH out of range',
        'snf_below_8.8' => 'Solid-not-fat below 8.8',
    ])
    ->columns(2)
    ->bulkToggleable()
    ->searchable()
    ->afterStateUpdated(fn ($state, callable $set) => 
    $set('rejection_reason', is_array($state) ? implode(', ', $state) : $state)
),
                TextInput::make('total_accepted_milk')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('farmer.name')
               ->label('Farmer Name')
            ->sortable(),
                Tables\Columns\TextColumn::make('date_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_collected')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' L'),
                
                Tables\Columns\TextColumn::make('quality_check'),
                Tables\Columns\TextColumn::make('rejection_reason')
    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state) // Ensure it's an array before imploding
    ->badge()
    ->color('danger')
    ->sortable(),
                Tables\Columns\TextColumn::make('total_accepted_milk')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' L'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMilkCollections::route('/'),
            'create' => Pages\CreateMilkCollection::route('/create'),
            'view' => Pages\ViewMilkCollection::route('/{record}'),
            'edit' => Pages\EditMilkCollection::route('/{record}/edit'),
        ];
    }
}
