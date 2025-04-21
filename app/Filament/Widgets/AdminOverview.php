<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\SalesDistribution;
use App\Models\FinishedGood;
use App\Models\MilkCollection;
use App\Models\Farmer; // Import Farmer model

class AdminOverview extends BaseWidget
{
    
    protected function getStats(): array
    {
        return [
            // Total Sales Stat
            Stat::make('Total Sales', number_format($this->getTotalSales(), 0) . ' RWF')
                ->description('This month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            // Quantity Collected Stat
            Stat::make('Quantity Collected', number_format($this->getRemainingStock(), 0) . ' L')
                ->description('Total stock left')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning'),

            // Total Orders Stat
            Stat::make('Total Orders', $this->getTotalOrders())
                ->description('This month')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            // Total Farmers Stat
            Stat::make('Total Farmers', $this->getTotalFarmers())
                ->description('Registered farmers')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }

    // Method to calculate total sales
    protected function getTotalSales()
    {
        return SalesDistribution::sum('total_sales');
    }

    // Method to calculate remaining stock
    protected function getRemainingStock()
    {
        return MilkCollection::sum('quantity_collected');
    }

    // Method to calculate total orders
    protected function getTotalOrders()
    {
        return SalesDistribution::whereMonth('sales_date', now()->month)->count();
    }

    // Method to calculate total farmers
    protected function getTotalFarmers()
    {
        return Farmer::count();
    }
}
