<?php

namespace App\Modules\FrontDeskUser\Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\Assert;
use Illuminate\Http\UploadedFile;
use App\Modules\Patient\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontDeskUserTest extends TestCase
{
  use RefreshDatabase;

  public function test_front_desk_users_can_visit_their_dashboard()
  {

    $this->set_user_props($actve = true, $activated = true);

    $rsp = $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user))->get(route($this->front_desk_user->dashboardRoute()))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('FrontDeskUser::Dashboard')
      ->url('/frontdesk-users/dashboard')
      ->has('authuser', fn($page) => $page
        ->where('name', $this->front_desk_user->name)
        ->etc()
      )
    );

  }

  public function test_front_desk_users_can_view_patients()
  {
    Patient::factory()->count(10)->create();

    $rsp = $this->actingAs($this->front_desk_user, $this->getAuthGuard($this->front_desk_user))->get(route('patients.show'))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('Patient::PatientList')
      ->url('/patients')
      ->has('patients', 10)
    );
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

}
