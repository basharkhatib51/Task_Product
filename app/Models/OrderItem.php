<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'quantity', 'product_id'];

    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): belongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
