<?php

namespace App\Modules\UserAuth\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsStaff
{
  public static function boot()
  {
    parent::boot();

    static::creating(function ($model)
    {
      $model->forceFill(['user_type' => static::class]);
    });
  }

  public static function booted()
  {
    parent::boot();

    static::addGlobalScope('model', function (Builder $builder)
    {
      $builder->where('user_type', static::class);
    });
  }
}
