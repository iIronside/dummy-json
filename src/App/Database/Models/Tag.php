<?php

namespace Console\App\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $fillable = [
        'title',
    ];
}