<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_posts';
    protected $fillable = ['title', 'slug', 'content', 'image'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($blogPost) {
            $blogPost->slug = Str::slug($blogPost->title) . '-' . time();
        });

        static::updating(function ($blogPost) {
            $blogPost->slug = Str::slug($blogPost->title) . '-' . time();
        });
    }
}

