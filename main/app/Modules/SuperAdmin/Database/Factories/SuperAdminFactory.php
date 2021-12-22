<?php
namespace App\Modules\SuperAdmin\Database\Factories;

use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuperAdminFactory extends Factory
{
  /**
  * The name of the factory's corresponding model.
  *
  * @var string
  */
  protected $model = SuperAdmin::class;

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
      'user_type' => SuperAdmin::class,
    ];
  }
}
