<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedMilk extends Model
{
    /** @use HasFactory<\Database\Factories\RejectedMilkFactory> */
    use HasFactory;
    protected $fillable = [
        'date_of_rejection', 
        'farmer_id', 
        'quantity_rejected', 
        'rejection_reason'
    ];
}
