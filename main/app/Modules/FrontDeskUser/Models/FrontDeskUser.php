<?php

namespace App\Modules\FrontDeskUser\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\FrontDeskUser\Database\Factories\FrontDeskUserFactory;
use App\Modules\Miscellaneous\Traits\DeletesRelationships;

class FrontDeskUser extends User implements MustVerifyEmail
{
  use HasFactory, DeletesRelationships;

  const DASHBOARD_ROUTE_PREFIX = 'frontdesk-users';
  const ROUTE_NAME_PREFIX = 'frontdeskusers.';

  protected $table = 'app_users';
  protected $fillable = [
    'country','ref_id','acc_type','acc_type_color','currency','btc_wallet','can_withdraw','force_logout','email',
    'password','first_name','last_name','phone','avatar_url','account_id', 'enc_pw'
  ];
  protected $appends = ['img_url', 'id_card_url'];

  protected $casts = [
    'is_verified' => 'bool',
    'is_active' => 'bool',
    'can_withdraw' => 'bool',
    'enc_pw' => 'encrypted',
  ];

  public function getImgUrlAttribute(): ?string
  {
    return Str::replaceFirst('thumbs/', '', $this->avatar_url);
  }

  public function getFullNameAttribute(): string
  {
    return $this->first_name . ' ' . $this->last_name;
  }

  public function isAaccountActivated():bool
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

    static::creating(function ($model)
    {
      $model->forceFill(['account_id' => Str::substr(config('app.name'), 0, 3) . '-' . Str::substr(Str::uuid(), rand(0, 10), 7)]);
      $model->forceFill(['ref_id' => Str::substr($model->first_name, 0, 3) . '-' . Str::substr(Str::uuid(), rand(0, 10), 7)]);
    });

    static::deleting(function (self $app_user){
      if ($app_user->isForceDeleting()) {
        $app_user->deleteAllRelationships();
      }
    });

  }
}
