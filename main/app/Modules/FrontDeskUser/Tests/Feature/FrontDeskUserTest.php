<?php

namespace App\Modules\FrontDeskUser\Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Inertia\Testing\Assert;
use Illuminate\Http\UploadedFile;
use App\Modules\Nurse\Models\Nurse;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\Patient\Models\Patient;
use App\Modules\Appointment\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontDeskUserTest extends TestCase
{
  use RefreshDatabase;


  public function test_front_desk_user_visit_login_page()
  {
    $rsp = $this->get(route('auth.login'))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('UserAuth::Login')
      ->url('/login')
      ->has('can_reset_password')
      ->has('status')
    );
  }

  public function test_front_desk_user_can_login()
  {

    $this->post(route('auth.login'), ['email' => $this->front_desk_user->email, 'password' => 'pass'])
    ->assertSessionMissing('flash.error')
    ->assertSessionHasNoErrors()
    ->assertRedirect(route($this->front_desk_user->dashboardRoute()));

    $this->assertAuthenticated($this->getAuthGuard($this->front_desk_user));
  }

  public function test_front_desk_users_can_visit_their_dashboard()
  {

    $this->set_user_props($actve = true, $activated = true);

    $patients = Patient::factory()->count(10)->create();
    $doctors = Doctor::factory()->count(2)->create();

    dump('seeding 10 thousand records ...');

    for ($i=0; $i < 10_000; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => $this->faker->dateTimeBetween('-3 years', '-1 day')->format('Y-m-d')
      ]);
    }

    dump('Done! Proceeding with tests');

    for ($i=0; $i < 10; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => now()
      ]);
    }

    $rsp = $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user))->get(route($this->front_desk_user->dashboardRoute()))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('FrontDeskUser::Dashboard')
      ->url('/frontdesk-users/dashboard')
      ->has('authuser', fn($page) => $page
        ->where('name', $this->front_desk_user->name)
        ->etc()
      )
      ->has('due_appointments', 10)
    );

  }

  public function test_front_desk_users_can_view_patients_list()
  {
    Patient::factory()->count(10)->create();

    $rsp = $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user))->get(route('patients.index'))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('Patient::PatientList')
      ->url('/patients')
      ->has('patients', 10)
    );
  }

  public function test_front_desk_users_can_view_a_patients_records()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    Appointment::factory()->discharged()->count(10)->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'front_desk_user_id' => $this->front_desk_user->id]);
    Appointment::factory()->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'front_desk_user_id' => $this->front_desk_user->id]);

    $rsp = $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user))->get(route('patients.show', $patient))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('FrontDeskUser::PatientDetails')
      ->url('/patients/'. $patient->id)
      ->has('patient', fn($page) => $page
        ->has('appointments', 11, fn($page) => $page
          ->where('case_notes', [])
          ->etc()
        )
        ->etc()
      )
      ->has('pending_appointment', fn($page) => $page
        ->where('doctor.name', $doctor->name)
        ->where('booked_by.name', $this->front_desk_user->name)
        ->etc()
      )
    );
  }

  public function test_front_desk_users_can_delete_a_patients_appointment()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    $appointment = Appointment::factory()->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'front_desk_user_id' => $this->front_desk_user->id]);

    $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user))->delete(route('appointments.delete', $appointment))
        ->assertRedirect()
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('flash.error')
        ->assertSessionHas('flash.success', 'Appointment has been cancelled.');

    $this->assertDeleted($appointment);
  }

  public function test_front_desk_users_cannot_delete_a_posted_patient_appointment()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();
    $nurse = Nurse::factory()->create();
    $appointment = Appointment::factory()->posted($nurse->id)->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'front_desk_user_id' => $this->front_desk_user->id]);

    $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user))->delete(route('appointments.delete', $appointment))
        ->assertStatus(403);

  }

  public function test_front_desk_users_can_create_patients()
  {
    $this->assertDatabaseCount('patients', 0);

    $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user));

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

  public function test_front_desk_users_can_book_appointments()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();

    $this->assertDatabaseCount('patients', 1);
    $this->assertDatabaseCount('doctors', 1);
    $this->assertDatabaseCount('appointments', 0);

    $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user));

    $this->post(route('appointments.create', $patient), [
      'doctor_id' => $doctor->id,
      'appointment_date' => $this->faker->dateTimeBetween('now', '+3 months'),
    ])
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Patient appointment booked. The assigned doctor will see the appointment in his schedule.');

    $this->assertDatabaseCount('patients', 1);
    $this->assertDatabaseCount('appointments', 1);
  }

  public function test_front_desk_users_can_view_appointments_by_date()
  {
    $patients = Patient::factory()->count(10)->create();
    $doctors = Doctor::factory()->count(2)->create();

    for ($i=0; $i < 1000; $i++) {
      Appointment::factory()->create([
        'doctor_id' => $this->faker->randomElement($doctors->pluck('id')),
        'patient_id' => $this->faker->randomElement($patients->pluck('id')),
        'front_desk_user_id' => $this->front_desk_user->id,
        'appointment_date' => $this->faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d')
      ]);
    }

    $this->assertDatabaseCount('patients', 10);
    $this->assertDatabaseCount('doctors', 2);

    $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user));

    $rsp = $this->get(route('appointments.index', $date = $this->faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d') ))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('Appointment::AppointmentList')
      ->url('/appointments/'. $date)
      ->where('appointments.current_page', 1)
      ->has('appointments.links')
      ->where('appointments.per_page', 15)
      ->has('appointments.data', 15, fn($page) => $page
        ->where('doctor.name', fn($val) => $doctors->contains(fn($v) => $v->name == $val))
        ->where('booked_by.name', $this->front_desk_user->name)
        ->where('appointment_date', fn($dt) => Carbon::parse($dt)->isSameDay(Carbon::parse($date)))
        ->has('patient')
        ->where('discharged_at', null)
        ->etc()
      )
    );
  }

  public function test_front_desk_users_can_post_appointments_for_vitals()
  {
    $patient = Patient::factory()->create();
    $doctor = Doctor::factory()->create();

    $appointment = Appointment::factory()->create([
      'doctor_id' => $doctor->id,
      'patient_id' => $patient->id,
      'front_desk_user_id' => $this->front_desk_user->id,
      'appointment_date' => now()
    ]);

    $this->assertFalse($appointment->isPosted());

    $this->assertDatabaseCount('patients', 1);
    $this->assertDatabaseCount('doctors', 1);
    $this->assertDatabaseCount('appointments', 1);

    $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user));

    $this->put(route('appointments.post_for_vitals', $appointment))
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Patient appointment posted. They can proceed to the nusring unit for their vitals.');

      $this->assertTrue($appointment->refresh()->isPosted());
  }
}
