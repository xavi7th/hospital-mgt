<?php

namespace App\Modules\Miscellaneous\Listeners;

use Illuminate\Database\Events\MigrationsEnded;
use App\Modules\SuperAdmin\Database\State\EnsureSuperAdminIsPresentInDatabase;
use App\Modules\Miscellaneous\Database\State\EnsureForexChartsArePresentInDatabase;
use App\Modules\Miscellaneous\Database\State\EnsureTestimonialsArePresentInDatabase;

class EnsureDatabaseIsSetupForSeeding
{
  /**
   * Handle the event.
   *
   * @param  \Illuminate\Database\Events\MigrationsEnded  $event
   * @return void
   */
  public function handle(MigrationsEnded $event)
  {
    collect([
      new EnsureSuperAdminIsPresentInDatabase,
      new EnsureForexChartsArePresentInDatabase,
      new EnsureTestimonialsArePresentInDatabase,
    ])->each->__invoke();
  }
}
