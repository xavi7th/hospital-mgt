<?php

namespace App\Modules\Doctor\Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\Assert;
use App\Modules\Nurse\Models\Nurse;
use App\Modules\Nurse\Models\Vitals;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\Patient\Models\Patient;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\CaseNote\Models\CaseNote;

class DoctorTest extends TestCase
{

  public function test_doctor_visit_login_page()
  {
    $rsp = $this->get(route('auth.login'))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('UserAuth::Login')
      ->url('/login')
      ->has('can_reset_password')
      ->has('status')
    );
  }

  public function test_doctor_can_login()
  {
    $doctor = Doctor::factory()->create();

    $this->post(route('auth.login'), ['email' => $doctor->email, 'password' => 'pass'])
    ->assertSessionMissing('flash.error')
    ->assertSessionHasNoErrors()
    ->assertRedirect(route($doctor->dashboardRoute()));

    $this->assertAuthenticated($this->getAuthGuard($doctor));
  }

  public function test_doctors_can_visit_their_dashboard()
  {
    $patients = Patient::factory()->count(100)->create();
    $doctors = Doctor::factory()->count(2)->create();
    $doctor = Doctor::factory()->activated()->active()->create();
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
     * Control to make sure that only appointments posted today are sent to the doctors dashboard.
     * ? The doctor can always go to patients list to view other patients / appointments
     */
    for ($i = 0; $i < 60; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'nurse_id' => $nurse->id,
        'appointment_date' => $this->faker->dateTimeBetween('-3 years', '-1 day')->format('Y-m-d'),
        'posted_at' => $this->faker->dateTimeBetween('-3 years', '-1 day')->format('Y-m-d')
      ]);
    }

    for ($i = 0; $i < 6; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'nurse_id' => $nurse->id,
        'appointment_date' => now()->subHours(5),
        'posted_at' => now()
      ]);
    }

    /**
     *? Control to confirm that appointments that already have been discharged are not sent back to the Doctor
     */
    Appointment::factory()->create([
      'doctor_id' => $doctor->id,
      'patient_id' => $this->faker->randomElement($patients->pluck('id')),
      'front_desk_user_id' => $this->front_desk_user->id,
      'nurse_id' => $nurse->id,
      'appointment_date' => now()->subHours(5),
      'posted_at' => now(),
      'discharged_at' => now(),
    ]);

    $rsp = $this->actingAs($doctor, $this->getAuthGuard($doctor))->get(route($doctor->dashboardRoute()))->assertOk();

    $rsp->assertInertia(
      fn (Assert $page) => $page
        ->component('Doctor::Dashboard')
        ->url('/doctors/dashboard')
        ->where('authuser.name', $doctor->name)
        ->has('appointments', 6, fn ($page) => $page
          ->has('patient')
          ->has('nurse')
          ->has('case_notes')
          ->where('doctor_id', $doctor->id)
          ->where('posted_at', fn ($v) => !is_null($v))
          ->where('discharged_at', fn ($v) => is_null($v))
          ->etc()
        )
    );
  }

  public function test_doctors_can_view_patients_list()
  {
    $patients = Patient::factory()->count(100)->create();
    $doctors = Doctor::factory()->count(2)->create();
    $doctor = Doctor::factory()->activated()->active()->create();
    $nurse = Nurse::factory()->activated()->active()->create();

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

    for ($i = 0; $i < 60; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'patient_id' => $this->faker->randomElement([1,2,3]),
        'front_desk_user_id' => $this->front_desk_user->id,
        'nurse_id' => $nurse->id,
        'appointment_date' => $this->faker->dateTimeBetween('-3 years', '-1 day')->format('Y-m-d'),
        'posted_at' => $this->faker->dateTimeBetween('-3 years', '-1 day')->format('Y-m-d')
      ]);
    }

    for ($i = 0; $i < 16; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'patient_id' => $this->faker->randomElement([4,5]),
        'front_desk_user_id' => $this->front_desk_user->id,
        'nurse_id' => $nurse->id,
        'appointment_date' => now()->subHours(5),
        'posted_at' => now()
      ]);
    }

    /**
     *? Control to confirm that appointments that already have been discharged are not sent back to the Doctor
     */
    for ($i = 0; $i < 40; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $doctor->id,
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'nurse_id' => $nurse->id,
        'appointment_date' => now()->subHours(5),
        'posted_at' => now(),
        'discharged_at' => now(),
      ]);
    }

    $rsp = $this->actingAs($doctor, $this->getAuthGuard($doctor))->get(route('patients.index'))->assertOk();

    $rsp->assertInertia(
      fn (Assert $page) => $page
        ->component('Patient::PatientList')
        ->url('/patients')
        ->has('patients', 5, fn ($page) => $page
          ->has('appointments', fn ($page) => $page
            ->has('0.doctor')
            ->has('0.nurse')
            ->has('0.case_notes')
            ->etc()
          )
          ->where('is_active', true)
          ->etc()
        )
    );
  }

  public function test_doctors_can_view_a_patients_case_notes()
  {
    $patients = Patient::factory()->count(100)->create();
    $doctors = Doctor::factory()->count(2)->create();
    $patient = Patient::factory()->create();
    $nurse = Nurse::factory()->activated()->active()->create();
    $doctor = Doctor::factory()->activated()->active()->create();

    for ($i = 0; $i < 100; $i++) {
      $appt = Appointment::factory()->create([
        'doctor_id' => $did = $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => now()->subHours(5),
        'nurse_id' => $nurse->id,
        'posted_at' => now()
      ]);
      Vitals::factory()->create([
        'nurse_id' => $nurse->id,
        'appointment_id' => $appt->id,
        'vitals' => ['temp' => $this->faker->randomNumber(), 'height' => $this->faker->randomNumber(), 'weight' => $this->faker->randomNumber()],
      ]);
      CaseNote::factory()->count(10)->create(['appointment_id' => $appt->id, 'doctor_id' => $did]);
    }

    $appointment = Appointment::factory()->create([
      'doctor_id' => $doctor->id,
      'patient_id' => $patient->id,
      'front_desk_user_id' => $this->front_desk_user->id,
      'nurse_id' => $nurse->id,
      'appointment_date' => now()->subHours(5),
      'posted_at' => now()
    ]);

    Vitals::factory()->count(15)->create([
      'nurse_id' => $nurse->id,
      'appointment_id' => $appointment->id,
    ]);

    CaseNote::factory()->count(10)->create(['appointment_id' => $appointment->id, 'doctor_id' => $doctor->id]);

    $rsp = $this->actingAs($doctor, $this->getAuthGuard($doctor))->get(route('casenotes.index', $appointment))->assertOk();

    $rsp->assertInertia(
      fn (Assert $page) => $page
        ->component('CaseNote::ViewCaseNotes')
        ->url('/case-notes/' . $appointment->id)
        ->has('appointment', fn($page) => $page
          ->has('case_notes', 10, fn($page) => $page
            ->where('doctor.name', $doctor->name)
            ->etc()
          )
          ->has('vital_signs', 15, fn($page) => $page
            ->where('nurse.name', $nurse->name)
            ->etc()
          )
          ->etc()
        )
    );
  }

  public function test_doctors_can_record_patients_case_notes()
  {


    $this->assertDatabaseCount('case_notes', 0);$patient = Patient::factory()->create();
    $nurse = Nurse::factory()->activated()->active()->create();
    $doctor = Doctor::factory()->activated()->active()->create();
    $appointment = Appointment::factory()->create([
      'doctor_id' => $doctor->id,
      'patient_id' => $patient->id,
      'front_desk_user_id' => $this->front_desk_user->id,
      'nurse_id' => $nurse->id,
      'appointment_date' => now()->subHours(5),
      'posted_at' => now()
    ]);

    Vitals::factory()->create([
      'nurse_id' => $nurse->id,
      'appointment_id' => $appointment->id,
      'vitals' => ['temp' => $this->faker->randomNumber(), 'height' => $this->faker->randomNumber(), 'weight' => $this->faker->randomNumber()],
    ]);

    $this->actingAs($doctor, $this->getAuthGuard($doctor));

    $this->post(route('casenotes.create', $appointment), ['patient_symptoms' => $this->faker->sentences(5, true), 'diagnosis' => $this->faker->sentences(10, true), 'prescriptions' => $this->faker->sentences(3, true)])
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Case Note updated!');

    $this->assertTrue(CaseNote::first()->is($appointment->case_notes->first()));
    $this->assertTrue($patient->case_notes->first()->is($appointment->case_notes->first()));

    $this->assertDatabaseCount('case_notes', 1);
  }
}
