<?php

namespace Console\App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $fillable = [
        'product_id',
        'rating',
        'comment',
        'date',
        'reviewer_name',
        'reviewer_email'
    ];
}