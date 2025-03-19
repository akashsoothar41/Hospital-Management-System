<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "first_name" , "last_name" , "email",   "role",    "status",  "password"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function experiences()
    {
        return $this->hasMany(Experience::class, 'doctor_id');
    }

    // Assuming the user has one profile
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    // Assuming the user has many educations
    public function educations()
    {
        return $this->hasMany(Education::class, 'doctor_id');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id'); // Linking to the speciality table via speciality_id
    }
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    public function attachments()
    {
        return $this->hasMany(DoctorAttachment::class, 'doctor_id');
    }

    public function patientReviews()
    {
        return $this->hasMany(Review::class, 'patient_id');
    }

    // For reviews where the user is the doctor
    public function doctorReviews()
    {
        return $this->hasMany(Review::class, 'doctor_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'doctor_id', 'patient_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'doctor_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
