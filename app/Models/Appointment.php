<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'patient_id', 'stripe_invoice_id' ,'day', 'start_time', 'end_time', 'status', 'invoice_status', 'amount_paid', 'amount_due'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Relationship to the patient (User model)
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

}
