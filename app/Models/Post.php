<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $appends = ['image_url'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function getImageUrlAttribute()
    // {
    //     return $this->feature_image
    //         ? asset('storage/' . $this->feature_image)
    //         : null;
    // }
}
