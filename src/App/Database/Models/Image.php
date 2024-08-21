<?php

namespace Console\App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';
    protected $fillable = [
        'product_id',
        'url',
    ];

}