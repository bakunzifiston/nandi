<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'processing_production_id',
        'product_id',
        'sales_date',
        'finished_good_id',
        'quantity_sold',
        'customer_retailer_name',
        'price_per_unit',
        'total_sales',
        'amount_paid',
        'delivery_status',
        'payment_method',
        'loan_status',
    ];

    // Define the relationship with Product
   
    public function product()
    {
        return $this->belongsTo(Product::class); // This defines the relationship
    }
    public function processingProduction()
    {
        return $this->belongsTo(ProcessingProduction::class); // This defines the relationship
    }
    // In SalesDistribution model
    public function finishedGood()
    {
        return $this->belongsTo(FinishedGood::class, 'finished_good_id');  // Ensure correct foreign key is used
    }
    // Auto-calculate total sales when creating/updating
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($sales) {
            $sales->total_sales = $sales->quantity_sold * $sales->price_per_unit;
        });

        static::created(function ($salesDistribution) {
            // Reduce the quantity collected when a new processing record is created
            $finishedGood = FinishedGood::find($salesDistribution->finished_good_id);
            if ($finishedGood) {
                $finishedGood->decrement('stock_quantity', $salesDistribution->quantity_sold);
            }
        });
    } 
}
