<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';
    protected $fillable = [
        'doctor_id',  'university', 'field', 'certificate_1', 'certificate_2', 'certificate_3', 'start_date', 'end_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
