<?php

namespace Console\App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tag';
    protected $fillable = [
        'product_id',
        'tag_id'
    ];
}