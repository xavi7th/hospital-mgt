<?php

namespace App\Modules\Doctor\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Doctor\Database\factories\DoctorFactory;

class Doctor extends User
{
  use HasFactory;

  protected $fillable = ['name', 'email', 'password', 'avatar_url'];
  protected $casts = [
    'account_activated_at' => 'timestamp',
    'is_active' => 'bool',
  ];

  protected static function newFactory()
  {
    return DoctorFactory::new();
  }
}
