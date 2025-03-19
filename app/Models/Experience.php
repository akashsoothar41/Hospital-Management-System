<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;


    protected $fillable = [
        'doctor_id', 'hospital_name', 'position', 'start_date', 'end_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
