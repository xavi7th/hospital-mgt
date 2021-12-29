<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Modules\Nurse\Models\Nurse;
use Illuminate\Support\Facades\Auth;
use App\Modules\Doctor\Models\Doctor;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Modules\Miscellaneous\Traits\DeletesRelationships;

class User extends Authenticatable
{
  use HasFactory, Notifiable, DeletesRelationships;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['email', 'password','name', 'avatar_url'];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['password','remember_token'];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = ['is_active' => 'bool',];

  protected $dates = ['account_activated_at'];

  public function isSuperAdmin(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isNurse(): bool
  {
    return $this instanceof Nurse;
  }

  public function isDoctor(): bool
  {
    return $this instanceof Doctor;
  }

  public function isFrontDeskUser(): bool
  {
    return $this instanceof FrontDeskUser;
  }

  public function dashboardRoute(): string
  {
    return Str::plural(strtolower($this->getType())) . '.dashboard';
  }

  public function getUserType()
  {
    switch (true) {
      case $this->isSuperAdmin():
        $user_type = ['isSuperAdmin' => true];
        break;
      case $this->isFrontDeskUser():
        $user_type = ['isFrontDeskUser' => true];
        break;
      case $this->isDoctor():
        $user_type = ['isDoctor' => true];
        break;
      case $this->isNurse():
        $user_type = ['isNurse' => true];
        break;
      default:
        $user_type = [];
        break;
    }
    return array_merge($user_type, ['user_type' => strtolower($this->getType())]);
  }

  public function getType(): string
  {
    return class_basename(get_class($this));
  }

  public function authGuard()
  {
    return Str::snake($this->getType());
  }

  public function logout(): void
  {
    Auth::guard($this->authGuard())->logout();
  }

  public function isAccountActivated():bool
  {
    return config('app.must_activate_users') ? ! ($this->isSuperAdmin() || is_null($this->account_activated_at)) : true;
  }

  public function scopeUnactivated(Builder $query)
  {
    return $query->whereNull('account_activated_at');
  }

  public function scopeSuspended(Builder $query)
  {
    return $query->where('is_active', false);
  }

  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = bcrypt($value);
  }

  static function boot()
  {
    parent::boot();

    static::deleting(function (self $user){
      if ($user->isForceDeleting()) {
        $user->deleteAllRelationships();
      }
    });
  }
}
