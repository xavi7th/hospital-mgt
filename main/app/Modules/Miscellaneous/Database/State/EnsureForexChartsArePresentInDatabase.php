<?php

namespace App\Modules\Miscellaneous\Database\State;

use App\Modules\Miscellaneous\Database\Seeders\ForexChartsTableSeeder;
use App\Modules\Miscellaneous\Models\ForexChart;

class EnsureForexChartsArePresentInDatabase
{
  public function __invoke()
  {
    if ($this->has_forex_charts()) {
      return;
    }
    (new ForexChartsTableSeeder())->run();
  }

  public function has_forex_charts(): bool
  {
    return ForexChart::count() > 0;
  }
}
