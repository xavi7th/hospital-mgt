<?php

namespace App\Modules\Doctor\Database\factories;

use App\Modules\Doctor\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Doctor::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'name' => $this->faker->name(),
      'email' => $this->faker->email(),
      'password' => 'pass',
      'avatar_url' => $this->faker->imageUrl(),
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
        'account_activated_at' => $this->faker->dateTimeThisMonth(),
      ];
    });
  }
}
