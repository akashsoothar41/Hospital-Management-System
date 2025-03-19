<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'doctor_id', 'speciality_id','title', 'description', 'status'
    ];
    protected $dates = ['deleted_at']; // Ensure 'deleted_at' is treated as a date

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id'); // Linking to the speciality table via speciality_id
    }

    public function attachments()
    {
        return $this->hasMany(BlogAttachment::class, 'blog_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany(BlogTag::class,'blog_id', 'id');
    }

    public function attachment(){
        return $this->hasOne(BlogAttachment::class,'blog_id');
    }
    public function comments(){
        return $this->hasOne(Comment::class,'blog_id');
    }
}
