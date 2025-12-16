<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_name', 'quantity', 'price', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    protected static function booted() {

        static::creating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
        });

        static::updating(function ($item) {
            $item->subtotal = $item->price * $item->quantity;
        });

        static::saved(function ($item) {
            $item->order->recalcTotal();
        });

        static::deleted(function ($item) {
            $item->order->recalcTotal();
        });
    }
}
