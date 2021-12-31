<?php

namespace App\Modules\Nurse\Database\factories;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\Nurse\Models\Nurse;
use App\Modules\Nurse\Models\Vitals;
use Illuminate\Database\Eloquent\Factories\Factory;

class VitalsFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Vitals::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'nurse_id' => null,
      'appointment_id' => null,
      'vitals' => ['temp' => $this->faker->randomNumber(), 'height' => $this->faker->randomNumber(), 'weight' => $this->faker->randomNumber()],
    ];
  }


  public function with_nurse()
  {
    return $this->state(function (array $attributes) {
      return [
        'nurse_id' => Nurse::factory()->create()->id,
      ];
    });
  }

  public function with_appointment()
  {
    return $this->state(function (array $attributes) {
      return [
        'appointment_id' => Appointment::factory()->with_front_desk_user()->with_doctor()->create()->id,
      ];
    });
  }
}
