<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'order_date', 'due_date', 'status', 'total_price', 'advance_paid', 'notes'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
