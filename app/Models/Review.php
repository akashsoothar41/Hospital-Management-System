<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at']; // Ensure 'deleted_at' is treated as a date
    protected $fillable=['patient_id','title', 'description', 'rating', 'terms_accept'];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Define the relationship with the Doctor (User) - assuming 'doctor_id' column in 'reviews' table
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
