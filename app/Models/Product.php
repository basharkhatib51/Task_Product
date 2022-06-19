<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Product extends Model
{
    use HasFactory;


    public function order_item(): hasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function is_quantity_available($order_quantity)
    {
        if ($this->quantity_available >= $order_quantity) {
            return true;
        }
        return false;
    }
}
