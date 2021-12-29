<?php

namespace App\Modules\Nurse\Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Inertia\Testing\Assert;
use Illuminate\Http\UploadedFile;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\Patient\Models\Patient;
use App\Modules\Appointment\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NurseTest extends TestCase
{
  use RefreshDatabase;

  public function test_nurses_can_visit_their_dashboard()
  {

    $this->set_user_props($actve = true, $activated = true);

    $patients = Patient::factory()->count(10)->create();
    $doctors = Doctor::factory()->count(2)->create();

    dump('seeding 10 thousand records ...');

    for ($i=0; $i < 10_000; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'nurse_id' => $this->nurse->id,
        'appointment_date' => $this->faker->dateTimeBetween('-3 years', '-1 day')->format('Y-m-d')
      ]);
    }

    dump('Done! Proceeding with tests');

    for ($i=0; $i < 10; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'nurse_id' => $this->nurse->id,
        'appointment_date' => now()
      ]);
    }

    $rsp = $this->actingAs($this->nurse, $this->getAuthGuard($this->nurse))->get(route($this->nurse->dashboardRoute()))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('Nurse::Dashboard')
      ->url('/frontdesk-users/dashboard')
      ->has('authuser', fn($page) => $page
        ->where('name', $this->nurse->name)
        ->etc()
      )
      ->has('due_appointments', 10)
    );

  }

  public function test_nurses_can_view_patients_list()
  {
    Patient::factory()->count(10)->create();

    $rsp = $this->actingAs($this->nurse, $this->getAuthGuard($this->nurse))->get(route('patients.index'))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('Patient::PatientList')
      ->url('/patients')
      ->has('patients', 10)
    );
  }

  public function test_nurses_can_view_a_patients_records()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    Appointment::factory()->fulfilled()->count(10)->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'nurse_id' => $this->nurse->id]);
    Appointment::factory()->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'nurse_id' => $this->nurse->id]);

    $rsp = $this->actingAs($this->nurse, $this->getAuthGuard($this->nurse))->get(route('patients.show', $patient))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('Nurse::PatientDetails')
      ->url('/patients/'. $patient->id)
      ->has('patient', fn($page) => $page
        ->has('appointments', 11, fn($page) => $page
          ->where('case_note', [])
          ->etc()
        )
        ->etc()
      )
      ->has('pending_appointment', fn($page) => $page
        ->where('doctor.name', $doctor->name)
        ->where('booked_by.name', $this->nurse->name)
        ->etc()
      )
    );
  }

  public function test_nurses_can_delete_a_patients_appointment()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    Appointment::factory()->fulfilled()->count(10)->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'nurse_id' => $this->nurse->id]);
    $appointment = Appointment::factory()->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'nurse_id' => $this->nurse->id]);

    $this->actingAs($this->nurse, $this->getAuthGuard($this->nurse))->delete(route('appointments.delete', $appointment))
        ->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('flash.error')
        ->assertSessionHas('flash.success', 'Appointment has been cancelled.');

    $this->assertDeleted($appointment);
  }

  public function test_nurses_can_record_patients_vitals()
  {
    $this->assertDatabaseCount('patients', 0);

    $this->actingAs($this->nurse, $this->getAuthGuard($this->nurse));

    $this->post(route('patients.create'), [
      'email' => $this->faker->email(),
      'phone' => $this->faker->phoneNumber(),
      'name' => $this->faker->name(),
      'avatar' => UploadedFile::fake()->image('avatar.jpg'),
      'date_of_birth' => $this->faker->dateTimeThisCentury(),
      'next_of_kin' => $this->faker->name(),
      'next_of_kin_phone' => $this->faker->e164PhoneNumber(),
    ])
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Patient record created. You can now schedule appointments for this patient.');

    $this->assertDatabaseCount('patients', 1);
  }

  public function test_nurses_can_view_posted_appointments()
  {
    $patients = Patient::factory()->count(10)->create();
    $doctors = Doctor::factory()->count(2)->create();

    for ($i=0; $i < 1000; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'nurse_id' => $this->nurse->id,
        'appointment_date' => $this->faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d')
      ]);
    }

    $this->assertDatabaseCount('patients', 10);
    $this->assertDatabaseCount('doctors', 2);

    $this->actingAs($this->nurse, $this->getAuthGuard($this->nurse));

    $rsp = $this->get(route('appointments.index', $date = $this->faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d') ))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('Appointment::AppointmentList')
      ->url('/appointments/'. $date)
      ->where('appointments.current_page', 1)
      ->has('appointments.links')
      ->where('appointments.per_page', 15)
      ->has('appointments.data', 15, fn($page) => $page
        ->where('doctor.name', fn($val) => $doctors->contains(fn($v) => $v->name == $val))
        ->where('booked_by.name', $this->nurse->name)
        ->where('appointment_date', fn($dt) => Carbon::parse($dt)->isSameDay(Carbon::parse($date)))
        ->has('patient')
        ->where('fulfilled_at', null)
        ->etc()
      )
    );
  }

}
