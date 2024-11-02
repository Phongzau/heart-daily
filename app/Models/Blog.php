<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    public function BlogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function BlogComments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
