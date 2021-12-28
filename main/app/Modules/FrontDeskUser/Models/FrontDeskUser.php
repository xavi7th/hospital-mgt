<?php

namespace App\Modules\FrontDeskUser\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\FrontDeskUser\Database\Factories\FrontDeskUserFactory;
use App\Modules\Miscellaneous\Traits\DeletesRelationships;

class FrontDeskUser extends User
{
  use HasFactory, DeletesRelationships;

  const DASHBOARD_ROUTE_PREFIX = 'front-desk-users';
  const ROUTE_NAME_PREFIX = 'frontdeskusers.';

  protected $table = 'front_desk_users';
  protected $fillable = ['email', 'password','name', 'avatar_url'];

  protected $casts = [
    'is_active' => 'bool',
  ];

  protected $dates = ['account_activated_at'];

  public function getFullNameAttribute(): string
  {
    return $this->first_name . ' ' . $this->last_name;
  }

  public function isAccountActivated():bool
  {
    return config('app.must_activate_users') ? ! is_null($this->account_activated_at) : true;
  }

  public function scopeUnactivated(Builder $query)
  {
    return $query->whereNull('account_activated_at');
  }

  public function scopeSuspended(Builder $query)
  {
    return $query->where('is_active', false);
  }


  protected static function newFactory()
  {
    return FrontDeskUserFactory::new();
  }

  static function boot()
  {
    parent::boot();

    static::deleting(function (self $front_desk_user){
      if ($front_desk_user->isForceDeleting()) {
        $front_desk_user->deleteAllRelationships();
      }
    });
  }
}
