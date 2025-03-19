<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTag extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at']; // Ensure 'deleted_at' is treated as a date

    protected $fillable = [
      'blog_id', 'name'
    ];
}
