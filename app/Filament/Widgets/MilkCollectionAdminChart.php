<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\MilkCollection;

class MilkCollectionAdminChart extends ChartWidget
{
    protected static ?int $navigationSort = 3; // Adjust the sort order as needed
    protected static ?string $heading = 'Milk Collection (Monthly)';

    protected function getData(): array
    {
        // Get total accepted milk per month for the current year
        $milkData = MilkCollection::selectRaw('SUM(total_accepted_milk) as total_milk, MONTH(date_time) as month')
            ->whereYear('date_time', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare the data for 12 months
        $milkByMonth = array_fill(0, 12, 0); 

        foreach ($milkData as $data) {
            $milkByMonth[$data->month - 1] = $data->total_milk;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Accepted Milk (Liters)',
                    'data' => $milkByMonth, 
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)', // Blue color
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Change to 'line', 'pie', etc., if needed
    }
}
