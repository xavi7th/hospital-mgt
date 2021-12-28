<?php

namespace App\Modules\Patient\Database\factories;

use App\Modules\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Patient::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'email' => $this->faker->email(),
      'name' => $this->faker->name(),
      'phone' => $this->faker->phoneNumber(),
      'avatar_url' => $this->faker->imageUrl(),
      'date_of_birth' => $this->faker->dateTimeThisCentury(),
      'next_of_kin' => $this->faker->name(),
      'next_of_kin_phone' => $this->faker->e164PhoneNumber(),
    ];
  }
}
