<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',  'speciality_id',  'image' , 'age' , 'address'  ,'date_of_birth',  'gender',  'phone_number' ,'emergency_contact' , 'about' ,  'fees'  ,  'start_time' , 'end_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function profile()
    {
        return $this->belongTo(User::class, 'patient_id');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id'); // Linking to the speciality table via speciality_id
    }

}
