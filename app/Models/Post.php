<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['feature_image'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFeatureImageAttribute($value)
    {
        $value = $this->feature_image;

        if (!$value) {
            return null;
        }

        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        return asset('storage/' . $value);
    }

}
