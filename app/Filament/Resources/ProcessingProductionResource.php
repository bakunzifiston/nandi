<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcessingProductionResource\Pages;
use App\Filament\Resources\ProcessingProductionResource\RelationManagers;
use App\Models\ProcessingProduction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\MilkCollection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\NumericInput;
use Filament\Forms\Components\TextInput;


class ProcessingProductionResource extends Resource
{
    protected static ?string $model = ProcessingProduction::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Select::make('milk_collection_id')
                        ->label('Milk Collection')
                        ->relationship('milkCollection', 'quantity_collected')
                        ->required()
                        ->preload(),
                

                Forms\Components\DatePicker::make('date_of_processing')
                    ->required(),
                    
               
                Forms\Components\TextInput::make('milk_used')
                ->numeric()
    ->required()
    ->reactive() // Makes the field reactive to changes
    ->minValue(0) // Minimum value 0
    ->suffix(' L') // Adds 'L' to indicate liters
    ->afterStateUpdated(function ($state, $get, $set) {
        // Custom validation after state update
        $milkCollectionId = $get('milk_collection_id');
        $milkCollection = \App\Models\MilkCollection::find($milkCollectionId);

        if ($milkCollection && $state > $milkCollection->quantity_collected) {
            // Trigger a custom error if 'milk_used' exceeds 'quantity_collected'
            $set('milk_used', $milkCollection->quantity_collected); // Reset to max valid value
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('The milk used cannot exceed the quantity collected.')
                ->danger()
                ->send();
        }
    }),

                Select::make('product_id')
                ->relationship('product','name')
                ->required(),
                Forms\Components\TextInput::make('quantity_produced')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('batch_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('wastage')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('wastage_reason')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_of_processing')
                    ->date()
                    ->sortable(),
            Tables\Columns\TextColumn::make('milk_used')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' L'),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product Name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity_produced')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('batch_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wastage')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('wastage_reason')
                    ->searchable(),
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
            'index' => Pages\ListProcessingProductions::route('/'),
            'create' => Pages\CreateProcessingProduction::route('/create'),
            'view' => Pages\ViewProcessingProduction::route('/{record}'),
            'edit' => Pages\EditProcessingProduction::route('/{record}/edit'),
        ];
    }
}
