<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAttachment extends Model
{
    use HasFactory;

    protected $fillable = [ 'doctor_id', 'file'];


    public function user()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
