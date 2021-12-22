<?php

namespace App\Modules\SuperAdmin\Database\State;

use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Database\Seeders\SuperAdminDatabaseSeeder;

class EnsureSuperAdminIsPresentInDatabase
{
  public function __invoke()
  {
    if ($this->has_super_admin()) {
      return;
    }
    (new SuperAdminDatabaseSeeder())->run();
  }

  public function has_super_admin(): bool
  {
    return SuperAdmin::count() > 0;
  }
}
