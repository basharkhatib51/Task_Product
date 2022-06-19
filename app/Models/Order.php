<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Order extends Model
{
    use HasFactory;

    public function order_items(): hasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
