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

  public function getFullNameAttribute(): string
  {
    return $this->first_name . ' ' . $this->last_name;
  }

  protected static function newFactory()
  {
    return FrontDeskUserFactory::new();
  }

}
