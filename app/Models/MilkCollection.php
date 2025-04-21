<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkCollection extends Model
{
    /** @use HasFactory<\Database\Factories\MilkCollectionFactory> */
    use HasFactory;
    
    protected $fillable = [
        'farmer_id', 
        'date_time', 
        'quantity_collected', 
        'quality_check', 
        'rejected_quantity', 
        'rejection_reason', 
        'total_accepted_milk'
    ];

    public function processingProductions()
    {
        return $this->hasMany(ProcessingProduction::class, 'milk_collection_id');
    }

    public function getAvailableMilkAttribute()
    {
        return $this->total_accepted_milk - $this->processingProductions()->sum('milk_used');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    // Convert stored rejection_reason string into an array when retrieving
    public function getRejectionReasonAttribute($value)
    {
        return explode(',', $value); // Convert string to array
    }

    // Convert rejection_reason array into a string when storing
    public function setRejectionReasonAttribute($value)
    {
        $this->attributes['rejection_reason'] = is_array($value) ? implode(',', $value) : $value;
    }
}