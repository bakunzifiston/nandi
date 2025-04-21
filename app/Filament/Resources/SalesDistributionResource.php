<?php

namespace App\Filament\Resources;

use App\Models\SalesDistribution;
use App\Filament\Resources\SalesDistributionResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Models\FinishedGood;

class SalesDistributionResource extends Resource
{
    protected static ?string $model = SalesDistribution::class;
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('processing_production_id')
    ->relationship('processingProduction', 'batch_number')
    ->required()
    ->label('Batch Number'),
                
                DatePicker::make('sales_date')
                    ->required()
                    ->label('Sales Date'),

                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),

                    Forms\Components\TextInput::make('quantity_sold')
                    ->numeric()
                    ->required()
                    ->reactive() // Makes the field reactive to changes
                    ->minValue(0) // Minimum value 0
                    ->afterStateUpdated(function ($state, $get) {
                        // Custom validation after state update
                        $finishedGoodid = $get('finished_goods_id');
                        $finishedGood = FinishedGood::find($finishedGoodid);
    
                        if ($finishedGood && $state > $finishedGood->stock_quantity) {
                            // Trigger a custom error if 'milk_used' exceeds 'stock_quantity'
                            $get('quantity_sold')->error('The milk used cannot exceed the stock quantity.');
                        }
                    }),

                TextInput::make('customer_retailer_name')
                    ->required()
                    ->label('Customer/Retailer Name'),

                TextInput::make('price_per_unit')
                    ->numeric()
                    ->step(0.01)
                    ->required()
                    ->label('Price Per Unit'),

                TextInput::make('total_sales')
                    ->numeric()
                    ->disabled() // Make it read-only
                    ->label('Total Sales')
                    ->dehydrated(false), // Avoid sending it in form requests since it's calculated
                
                    TextInput::make('amount_paid')
                    ->numeric()
                    ->required()
                    ->label('Amount Paid'), 

                Select::make('delivery_status')
                    ->options([
                        'Pending' => 'Pending',
                        'Delivered' => 'Delivered',
                        'Returned' => 'Returned',
                    ])
                    ->default('Pending')
                    ->label('Delivery Status'),

                 Forms\Components\Select::make('payment_method')
                    ->label('Payment Method')
                    ->required()
                    ->options([
                        'Cash' => 'Cash',
                        'Card' => 'Card',
                        'Mobile Money' => 'Mobile Money',
                    ])
                    ->searchable(),     

                Toggle::make('loan_status')
                    ->default(false)
                    ->label('Credit'),
                    Select::make('finished_good_id')
    ->relationship('finishedGood', 'stock_quantity')
    ->required()
    ->label('Stock Quantity'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('processingProduction.batch_number') // Display product name instead of ID
                    ->label('Batch number')
                    ->sortable()
                    ->searchable(),
                
               
                TextColumn::make('sales_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('product.name') // Display product name instead of ID
                    ->label('Product name')
                    ->sortable(),

                TextColumn::make('quantity_sold')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('customer_retailer_name')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('price_per_unit')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' RWF'),

                    Tables\Columns\TextColumn::make('total_sales')
                    ->getStateUsing(fn ($record) => $record->quantity_sold * $record->price_per_unit) // Calculate dynamically
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' RWF'), // Format and append "RWF"
                

                Tables\Columns\TextColumn::make('amount_paid')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' RWF'),


                TextColumn::make('delivery_status')
                ->searchable(),
                TextColumn::make('payment_method')
                   
                    ->sortable(),
                
                IconColumn::make('loan_status')
                    ->label('Credit')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // You can add filters if needed
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalesDistributions::route('/'),
            'create' => Pages\CreateSalesDistribution::route('/create'),
            'view' => Pages\ViewSalesDistribution::route('/{record}'),
            'edit' => Pages\EditSalesDistribution::route('/{record}/edit'),
        ];
    }
}
