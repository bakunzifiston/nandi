<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessingProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'milk_collection_id',
        'date_of_processing', 
        'milk_used', 
        'quantity_produced', 
        'batch_number', 
        'wastage', 
        'wastage_reason'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class); // This defines the relationship
    }
    public function milkCollection()
    {
        return $this->belongsTo(MilkCollection::class, 'milk_collection_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::created(function ($processingProduction) {
            // Reduce the quantity collected when a new processing record is created
            $milkCollection = MilkCollection::find($processingProduction->milk_collection_id);
            if ($milkCollection) {
                $milkCollection->decrement('quantity_collected', $processingProduction->milk_used);
            }
        });
    }
   
}

