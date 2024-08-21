<?php

namespace Console\App\Database\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'category',
        'price',
        'stock',
        'weight',
        'minimumOrderQuantity',
        'title',
        'warranty_information',
        'shipping_information',
        'availability_status',
        'returnPolicy',
        'description',
        'brand',
        'sku',
        'thumbnail',
        'discount_percentage',
        'rating',
    ];
}
