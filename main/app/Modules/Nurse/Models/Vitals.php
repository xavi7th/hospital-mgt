<?php

namespace App\Modules\Nurse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Nurse\Database\factories\VitalsFactory;

class Vitals extends Model
{
  use HasFactory;

  protected $fillable = ['nurse_id', 'appointment_id', 'vitals',];
  protected $casts = ['vitals' => 'object', 'nurse_id' => 'int', 'appointment_id' => 'int'];

  public function nurse()
  {
    return $this->belongsTo(Nurse::class);
  }

  protected static function newFactory()
  {
    return VitalsFactory::new();
  }
}
