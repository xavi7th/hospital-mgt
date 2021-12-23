<?php
namespace App\Modules\FrontDeskUser\Database\Factories;

use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FrontDeskUserFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = FrontDeskUser::class;

  /**
  * Define the model's default state.
  *
  * @return array
  */
  public function definition()
  {
    return [
      'email' => $this->faker->email(),
      'password' => 'pass',
      'name' => $this->faker->name(),
      'avatar_url' =>null,
      'account_activated_at' => null,
      'is_active' => false,
    ];
  }

  public function active()
  {
    return $this->state(function (array $attributes) {
      return [
        'is_active' => true,
      ];
    });
  }

  public function activated()
  {
    return $this->state(function (array $attributes) {
      return [
        'account_activated_at' => now()->subDays(3),
      ];
    });
  }
}
