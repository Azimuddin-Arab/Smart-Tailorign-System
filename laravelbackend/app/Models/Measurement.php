<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'chest',
        'waist',
        'hips',
        'sleeve_length',
        'shoulder',
        'neck',
        'inseam',
        'notes',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
