<?php

namespace App\Modules\CaseNote\Models;

use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;
use App\Modules\Appointment\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\CaseNote\Database\factories\CaseNoteFactory;
use App\Modules\Doctor\Models\Doctor;

class CaseNote extends Model
{
  use HasFactory, BelongsToThrough;

  protected $fillable = ['appointment_id', 'patient_symptoms', 'diagnosis', 'prescriptions', 'doctor_id'];
  protected $casts = [
    'appointment_id' => 'int',
    'doctor_id' => 'int',
  ];

  protected static function newFactory()
  {
    return CaseNoteFactory::new();
  }

  public function appointment()
  {
    return $this->belongsTo(Appointment::class);
  }

  public function doctor()
  {
    return $this->belongsToThrough(Doctor::class, Appointment::class);
  }
}
