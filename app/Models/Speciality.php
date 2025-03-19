<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'image',
        'status'
    ];

    public function doctors()
    {
        return $this->hasMany(User::class, 'speciality_id'); // Linking to the User table via speciality_id
    }


}

