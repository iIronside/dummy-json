<?php

namespace Console\App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Dimensions extends Model
{
    protected $table = 'dimensions';
    protected $fillable = [
        'product_id',
        'width',
        'height',
        'depth'
    ];
}