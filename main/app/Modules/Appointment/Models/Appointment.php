<?php

namespace App\Modules\Appointment\Models;

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
  protected $casts = ['patient_id' => 'int', 'doctor_id' => 'int'];
  protected $dates = ['appointment_date', 'fulfilled_at', 'posted_at'];

  protected static function newFactory()
  {
    return AppointmentFactory::new();
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function doctor()
  {
    return $this->belongsTo(Doctor::class);
  }

  public function booked_by()
  {
    return $this->belongsTo(FrontDeskUser::class, 'front_desk_user_id', 'id');
  }

  public function case_note()
  {
    return $this->hasMany(CaseNote::class);
  }

  public function isPosted(): bool
  {
    return ! is_null($this->posted_at);
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

  public function scopeDue(Builder $query)
  {
    return $query->whereDate('appointment_date', today())->whereYear('appointment_date', today());
  }
}
