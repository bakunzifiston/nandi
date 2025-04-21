<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'distruct', 'sector','contact_details'];

    public function milkCollections()
    {
        return $this->hasMany(MilkCollection::class);
    }

    public function rejectedMilk()
    {
        return $this->hasMany(RejectedMilk::class);
    }
}
