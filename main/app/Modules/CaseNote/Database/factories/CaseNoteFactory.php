<?php

namespace App\Modules\CaseNote\Database\factories;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\CaseNote\Models\CaseNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class CaseNoteFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = CaseNote::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'appointment_id' => null,
      'patient_symptoms' => $this->faker->sentences(3, true),
      'diagnosis' => $this->faker->sentences(3, true),
      'prescriptions' => $this->faker->sentences(3, true),
    ];
  }

  public function with_appointment()
  {
    return $this->state(function (array $attributes) {
      return [
        'appointment_id' => Appointment::factory()->create()->id,
      ];
    });
  }
}
