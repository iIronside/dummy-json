<?php

namespace Console\App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'meta';
    protected $fillable = [
        'product_id',
        'barcode',
        'qr_code',
        'updated_at',
        'created_at'
    ];
}