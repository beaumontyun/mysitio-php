<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_blogsimg extends Model
{
    use HasFactory;

    protected $table = 'user_blogsimg';

    protected $fillable = [
        'blogs_images_id',
        'users_id',
        'blogs_id'
    ];

}
