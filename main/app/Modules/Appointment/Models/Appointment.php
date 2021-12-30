<?php

namespace App\Modules\Appointment\Models;

use App\Modules\Nurse\Models\Nurse;
use App\Modules\Nurse\Models\Vitals;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use App\Modules\CaseNote\Models\CaseNote;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Appointment\Database\factories\AppointmentFactory;

class Appointment extends Model
{
  use HasFactory;

  protected $fillable = ['patient_id', 'doctor_id', 'appointment_date', 'front_desk_user_id'];
  protected $casts = ['patient_id' => 'int', 'doctor_id' => 'int', 'nurse_id' => 'int'];
  protected $dates = ['appointment_date', 'fulfilled_at', 'posted_at'];

  protected static function newFactory()
  {
    return AppointmentFactory::new();
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function vital_signs()
  {
    return $this->hasMany(Vitals::class);
  }

  public function doctor()
  {
    return $this->belongsTo(Doctor::class);
  }

  public function booked_by()
  {
    return $this->belongsTo(FrontDeskUser::class, 'front_desk_user_id', 'id');
  }

  public function posted_by()
  {
    return $this->belongsTo(Nurse::class, 'nurse_id', 'id');
  }

  public function case_notes()
  {
    return $this->hasMany(CaseNote::class);
  }

  public function isPosted(): bool
  {
    return ! is_null($this->posted_at);
  }

  public function hasTakenVitals(): bool
  {
    return ! is_null($this->nurse_id);
  }

  public function scopePending(Builder $query)
  {
    return $query->whereNull('fulfilled_at');
  }

  public function scopeFulfilled(Builder $query)
  {
    return $query->whereNotNull('fulfilled_at');
  }

  public function scopeNotPosted(Builder $query)
  {
    return $query->whereNull('posted_at');
  }

  public function scopePosted(Builder $query)
  {
    return $query->whereNotNull('posted_at');
  }

  public function scopeVitalsNotTaken(Builder $query)
  {
    return $query->whereNull('nurse_id');
  }

  public function scopeVitalsTaken(Builder $query)
  {
    return $query->whereNotNull('nurse_id');
  }

  public function scopeDue(Builder $query)
  {
    return $query->whereDate('appointment_date', today())->whereYear('appointment_date', today());
  }
}
