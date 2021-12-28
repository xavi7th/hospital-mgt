<?php

namespace App\Modules\Patient\Models;

use App\Modules\Appointment\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Patient\Database\factories\PatientFactory;

class Patient extends Model
{
  use HasFactory;

  protected $fillable = ['email', 'phone', 'name', 'avatar_url', 'date_of_birth', 'next_of_kin', 'next_of_kin_phone'];

  public function appointments()
  {
    return $this->hasMany(Appointment::class);
  }

  public function completed_appointments()
  {
    return $this->hasMany(Appointment::class)->fulfilled();
  }

  public function pending_appointment()
  {
    return $this->hasOne(Appointment::class)->ofMany()->pending();
  }

  protected static function newFactory()
  {
    return PatientFactory::new();
  }
}
