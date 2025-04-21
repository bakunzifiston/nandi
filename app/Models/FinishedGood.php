<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedGood extends Model
{
    /** @use HasFactory<\Database\Factories\FinishedGoodFactory> */
    use HasFactory;
    protected $fillable = [
        'product_id', 
        'processing_production_id',
        'stock_quantity', 
        'samples', 
        'damaged', 
        'expiration_date', 
        'storage_location'
    ];
 
    public function product()
    {
        return $this->belongsTo(Product::class); // This defines the relationship
    }
    public function processingProduction()
    {
        return $this->belongsTo(ProcessingProduction::class);
    }
}
