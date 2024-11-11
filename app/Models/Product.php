<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_serial_number',
        'product_description',
        'product_quantity',
        'product_purchase_price',
        'product_selling_price',
        'product_image',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}