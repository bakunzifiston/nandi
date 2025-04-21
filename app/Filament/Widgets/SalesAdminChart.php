<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SalesDistribution; // Make sure to include the model

class SalesAdminChart extends ChartWidget
{ 
    protected static ?int $navigationSort = 5; // Adjust the sort order as needed
    protected static ?string $heading = 'Monthly Sales Chart';

    protected function getData(): array
    {
        // Get sales data by month for the current year
        $salesData = SalesDistribution::selectRaw('SUM(total_sales) as total_sales, MONTH(sales_date) as month')
            ->whereYear('sales_date', now()->year)  // Filter by current year
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare the sales data for the chart (12 months)
        $salesByMonth = array_fill(0, 12, 0); // Initialize array with 0s for 12 months

        // Map the fetched sales data to the correct month
        foreach ($salesData as $data) {
            $salesByMonth[$data->month - 1] = $data->total_sales; // Store sales in the correct month index (0-based)
        }

        // Return chart data in the format Filament expects
        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $salesByMonth, // Dynamically set the sales data
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Month labels
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // You can change this to 'line', 'pie', etc., depending on your desired chart type
    }
}
