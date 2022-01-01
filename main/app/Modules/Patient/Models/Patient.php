<?php

namespace App\Modules\Patient\Models;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\CaseNote\Models\CaseNote;
use App\Modules\Nurse\Models\Vitals;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Patient\Database\factories\PatientFactory;

class Patient extends Model
{
  use HasFactory;

  protected $fillable = ['email', 'phone', 'name', 'avatar_url', 'date_of_birth', 'next_of_kin', 'next_of_kin_phone'];
  protected $casts = ['is_active' => 'bool'];

  public function appointments()
  {
    return $this->hasMany(Appointment::class);
  }

  public function past_appointments()
  {
    return $this->hasMany(Appointment::class)->discharged();
  }

  public function pending_appointment()
  {
    return $this->hasOne(Appointment::class)->ofMany([
        'id' => 'max',
    ], function ($query) {
        $query->whereNull('discharged_at');
    });
  }

  public function vital_signs()
  {
    return $this->hasManyThrough(Vitals::class, Appointment::class);
  }

  public function case_notes()
  {
    return $this->hasManyThrough(CaseNote::class, Appointment::class);
  }

  protected static function newFactory()
  {
    return PatientFactory::new();
  }
}
