<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    const UNKNOWN_USER = 1;
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content_raw',
        'content_html',
        'is_published',
        'published_at',
    ];
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
