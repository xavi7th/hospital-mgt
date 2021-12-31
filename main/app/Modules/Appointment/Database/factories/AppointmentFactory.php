<?php

namespace App\Modules\Appointment\Database\factories;

use App\Modules\Doctor\Models\Doctor;
use App\Modules\Patient\Models\Patient;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use App\Modules\Nurse\Models\Nurse;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Appointment::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'patient_id' => null,
      'doctor_id' => null,
      'front_desk_user_id' => null,
      'nurse_id' => null,
      'appointment_date' => $this->faker->dateTimeBetween('now', '+3 months'),
      'discharged_at' => null,
      'posted_at' => null,
    ];
  }

  public function with_patient()
  {
    return $this->state(function (array $attributes) {
      return [
        'patient_id' => Patient::factory()->create()->id,
      ];
    });
  }

  public function with_doctor()
  {
    return $this->state(function (array $attributes) {
      return [
        'doctor_id' => Doctor::factory()->create()->id,
      ];
    });
  }

  public function with_nurse()
  {
    return $this->state(function (array $attributes) {
      return [
        'nurse_id' => Nurse::factory()->create()->id,
      ];
    });
  }

  public function with_front_desk_user()
  {
    return $this->state(function (array $attributes) {
      return [
        'front_desk_user_id' => FrontDeskUser::factory()->create()->id,
      ];
    });
  }

  public function discharged()
  {
    return $this->state(function (array $attributes) {
      return [
        'discharged_at' => $this->faker->dateTimeThisMonth('now'),
      ];
    });
  }

  public function posted($nurse_id = null)
  {
    return $this->state(function (array $attributes) use($nurse_id) {
      return [
        'posted_at' => $this->faker->dateTimeThisMonth('now'),
        'nurse_id' => $nurse_id
      ];
    });
  }
}
