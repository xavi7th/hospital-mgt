<?php

namespace App\Modules\Miscellaneous\Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Container\Container;

class LivePayoutFactory
{

  protected $faker;
  protected $seeds;

  public function __construct()
  {
    $this->faker = Container::getInstance()->make(Faker::class);
    $this->seeds = collect([])->push($this->definition());
  }

  /**
   * Define the data state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'currency' => $this->faker->randomElement(['$', '£', '€', '¥', '₴', 'C$', '₩']),
      'amount_withdrawn' => $this->faker->numerify('#####'),
      'trading_id' => $this->faker->bothify('?##?#?##???'),
      'request_submitted' => $requested = now()->subDays($this->faker->randomDigitNotZero())->subHours($this->faker->randomDigitNotZero()),
      'days_processed' => now()->diffInWeekdays($requested)
    ];
  }

  public function make()
  {
    return $this->seeds;
  }

  public function count(int $count)
  {
    for ($i=1; $i < $count; $i++) {
      $this->seeds->push($this->definition());
    }
    return $this;
  }
}
