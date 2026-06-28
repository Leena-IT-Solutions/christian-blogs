<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    /**
     * Accessor to auto-migrate featured_image from storage/ to uploads/ on-the-fly.
     */
    public function getFeaturedImageAttribute($value)
    {
        if ($value && str_starts_with($value, 'storage/')) {
            $cleanPath = str_replace('storage/', '', $value);
            $oldPath = storage_path('app/public/' . $cleanPath);
            $newPath = public_path($cleanPath);

            if (file_exists($oldPath)) {
                if (!file_exists(dirname($newPath))) {
                    @mkdir(dirname($newPath), 0755, true);
                }
                if (!file_exists($newPath)) {
                    @copy($oldPath, $newPath);
                }
                // Update DB quietly
                $this->timestamps = false;
                $this->updateQuietly(['featured_image' => $cleanPath]);
                return $cleanPath;
            } else {
                if (file_exists($newPath)) {
                    $this->timestamps = false;
                    $this->updateQuietly(['featured_image' => $cleanPath]);
                    return $cleanPath;
                }
            }
        }
        return $value;
    }
}
