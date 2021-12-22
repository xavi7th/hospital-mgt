<?php

namespace App\Modules\SuperAdmin\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\SuperAdmin\Database\Factories\SuperAdminFactory;
use App\Modules\UserAuth\Traits\IsStaff;

class SuperAdmin extends User
{
    use HasFactory, IsStaff;

    const ROUTE_NAME_PREFIX = 'superadmins.';
    const DASHBOARD_ROUTE_PREFIX = 'super-admins';

    protected $table = 'staff';

    protected static function newFactory()
    {
        return SuperAdminFactory::new();
    }
}
