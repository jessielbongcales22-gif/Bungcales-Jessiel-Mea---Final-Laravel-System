<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['name', 'category', 'description', 'quantity', 'unit', 'price'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
