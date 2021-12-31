<?php

namespace App\Modules\Nurse\Models;

use App\Models\User;
use App\Modules\Nurse\Database\factories\NurseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nurse extends User
{
  use HasFactory;

  protected static function newFactory()
  {
    return NurseFactory::new();
  }
}
