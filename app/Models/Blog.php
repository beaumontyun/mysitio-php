<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // You do not need to use 'protected $table' if your table name is plural (per laravel default,
    // which recognises plural table name only), otherwise, use 'protected $table' to force laravel to recognise
    // singular named table.

    // protected $table = 'blogs';

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];
}
