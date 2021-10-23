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
        'blog_image',
        'user_id',
    ];

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
