<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinishedGoodResource\Pages;
use App\Filament\Resources\FinishedGoodResource\RelationManagers;
use App\Models\FinishedGood;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinishedGoodResource extends Resource
{
    protected static ?string $model = FinishedGood::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-hand-thumb-up';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),

                Select::make('processing_production_id')
                    ->relationship('processingProduction', 'batch_number')
                    ->required(),
                
                Forms\Components\TextInput::make('stock_quantity')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('samples')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('damaged')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\DatePicker::make('expiration_date')
                    ->required(),
                Forms\Components\TextInput::make('storage_location')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('processingProduction.batch_number')
                ->label('Batch number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('samples')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('damaged')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiration_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('storage_location')
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
            'index' => Pages\ListFinishedGoods::route('/'),
            'create' => Pages\CreateFinishedGood::route('/create'),
            'view' => Pages\ViewFinishedGood::route('/{record}'),
            'edit' => Pages\EditFinishedGood::route('/{record}/edit'),
        ];
    }
}
