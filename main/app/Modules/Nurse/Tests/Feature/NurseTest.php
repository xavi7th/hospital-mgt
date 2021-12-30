<?php

namespace App\Modules\Nurse\Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Inertia\Testing\Assert;
use Illuminate\Http\UploadedFile;
use App\Modules\Nurse\Models\Nurse;
use App\Modules\Nurse\Models\Vitals;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\Patient\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Appointment\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NurseTest extends TestCase
{
  use RefreshDatabase;

  public function test_nurses_can_visit_their_dashboard()
  {

    $patients = Patient::factory()->count(10)->create();
    $doctors = Doctor::factory()->count(2)->create();
    $nurse = Nurse::factory()->activated()->active()->create();

    dump('seeding 10 thousand records ...');

    for ($i = 0; $i < 10_000; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => $this->faker->dateTimeBetween('-3 years', '-1 day')->format('Y-m-d')
      ]);
    }

    dump('Done! Proceeding with tests');

    for ($i = 0; $i < 100; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => now()->subHours(5),
      ]);
    }

    for ($i = 0; $i < 10; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => now()->subHours(5),
        'posted_at' => now()
      ]);
    }

    /**
     *? Control to confirm that appointments that already have their vitals taken are not sent back to Nurse
     */
    Appointment::factory()->create([
      'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
      'patient_id' => $this->faker->randomElement($patients->pluck('id')),
      'front_desk_user_id' => $this->front_desk_user->id,
      'nurse_id' => $nurse->id,
      'appointment_date' => now()->subHours(5),
      'posted_at' => now()
    ]);

    $rsp = $this->actingAs($nurse, $this->getAuthGuard($nurse))->get(route($nurse->dashboardRoute()))->assertOk();

    $rsp->assertInertia(
      fn (Assert $page) => $page
        ->component('Nurse::Dashboard')
        ->url('/nurses/dashboard')
        ->has(
          'authuser',
          fn ($page) => $page
            ->where('name', $nurse->name)
            ->etc()
        )
        ->has(
          'posted_appointments',
          10,
          fn ($page) => $page
            ->has('patient')
            ->has('doctor')
            ->where('posted_at', fn ($v) => !is_null($v))
            ->where('nurse_id', fn ($v) => is_null($v))
            ->where('fulfilled_at', fn ($v) => is_null($v))
            ->etc()
        )
    );
  }

  public function test_nurses_can_view_patients_list()
  {
    $patients = Patient::factory()->count(10)->create();
    $doctors = Doctor::factory()->count(2)->create();
    $nurse = Nurse::factory()->activated()->active()->create();

    for ($i = 0; $i < 10; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => now()->subHours(5),
        'posted_at' => now()
      ]);
    }

    for ($i = 0; $i < 7; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement([1, 2]),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => now()->subHours(5),
        'posted_at' => now(),
        'nurse_id' => $nurse->id,
        'fulfilled_at' => now(),
      ]);
    }

    $rsp = $this->actingAs($nurse, $this->getAuthGuard($nurse))->get(route('patients.index'))->assertOk();

    $rsp->assertInertia(
      fn (Assert $page) => $page
        ->component('Patient::PatientList')
        ->url('/patients')
        ->has(
          'patients',
          2,
          fn ($page) => $page
            ->has(
              'appointments',
              fn ($page) => $page
                ->has('0.doctor')
                ->has('0.posted_by')
                ->has('0.case_notes')
                ->etc()
            )
            ->where('is_active', true)
            ->etc()
        )
    );
  }

  public function test_nurses_can_view_a_patients_case_notes()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    Appointment::factory()->fulfilled()->count(10)->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'nurse_id' => $nurse->id]);
    Appointment::factory()->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'nurse_id' => $nurse->id]);

    $rsp = $this->actingAs($nurse, $this->getAuthGuard($nurse))->get(route('appointments.case_notes', $appointment))->assertOk();

    $rsp->assertInertia(
      fn (Assert $page) => $page
        ->component('Nurse::CaseNotes')
        ->url('/patients/' . $patient->id)
        ->has(
          'patient',
          fn ($page) => $page
            ->has(
              'appointments',
              11,
              fn ($page) => $page
                ->where('case_note', [])
                ->etc()
            )
            ->etc()
        )
        ->has(
          'pending_appointment',
          fn ($page) => $page
            ->where('doctor.name', $doctor->name)
            ->where('booked_by.name', $nurse->name)
            ->etc()
        )
    );
  }

  public function test_nurses_can_record_patients_vitals()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    $nurse = Nurse::factory()->activated()->active()->create();

    $this->assertDatabaseCount('vitals', 0);

    $appointment = Appointment::factory()->create([
      'doctor_id' => $doctor->id,
      'patient_id' => $patient->id,
      'front_desk_user_id' => $this->front_desk_user->id,
      'appointment_date' => now()->subHours(5),
      'posted_at' => now()
    ]);

    $this->actingAs($nurse, $this->getAuthGuard($nurse));

    $this->post(route('appointments.vitals.create', $appointment), ['vitals' => ['temp' => $this->faker->randomNumber(), 'height' => $this->faker->randomNumber(), 'weight' => $this->faker->randomNumber()]])
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Patient\'s vitals recorded. They can proceed to see the doctor now.');

    $this->assertTrue(Vitals::first()->is($appointment->vital_signs->first()));
    $this->assertTrue($patient->vital_signs->first()->is($appointment->vital_signs->first()));

    $this->assertDatabaseCount('vitals', 1);
  }
}
