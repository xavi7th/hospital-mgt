<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\Assert;
use Illuminate\Http\UploadedFile;
use App\Modules\Nurse\Models\Nurse;
use App\Modules\Doctor\Models\Doctor;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;

class SuperAdminTest extends TestCase
{

  public function test_super_admin_visit_login_page()
  {
    $rsp = $this->get(route('auth.login'))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('UserAuth::Login')
      ->url('/login')
      ->has('can_reset_password')
      ->has('status')
    );
  }

  public function test_super_admin_can_login()
  {

    $this->post(route('auth.login'), ['email' => $this->super_admin->email, 'password' => 'pass'])
    ->assertSessionMissing('flash.error')
    ->assertSessionHasNoErrors()
    ->assertRedirect(route($this->super_admin->dashboardRoute()));

    $this->assertAuthenticated($this->getAuthGuard($this->super_admin));
  }

  public function test_super_admin_can_visit_dashboard()
  {
    $rsp = $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->get(route($this->super_admin->dashboardRoute()))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('SuperAdmin::SuperAdminDashboard')
      ->url('/super-admins')
      ->has('statistics', fn(Assert $props) => $props
        ->has('total_users_count')
        ->has('unverified_users_count')
      )
    );
  }

  public function test_super_admin_can_view_front_desk_users()
  {
    $rsp = $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->get(route('frontdeskusers.list'))->assertOk();

    $rsp->assertInertia(fn(Assert $page) => $page
      ->component('SuperAdmin::ManageUsers', false)
      ->has('front_desk_users', 1)
    );
  }

  public function test_super_admin_can_create_front_desk_users()
  {
    $this->assertDatabaseCount('front_desk_users', 1);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->post(route('frontdeskusers.create'),[
      'name' => 'Hello',
      'email' => 'hello@example.com',
      'password' => 'P@$$w0rd',
      'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ])
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Front Desk User account created. Activate the account so the user can login.');

      $this->assertDatabaseCount('front_desk_users', 2);

      $user = FrontDeskUser::latest('id')->first();

      $this->assertEquals('Hello', $user->name);
      $this->assertFalse($user->isAccountActivated());
      $this->assertTrue($user->is_active);
  }

  public function test_super_admin_can_suspend_front_desk_user()
  {
    $this->front_desk_user->is_active = true;
    $this->front_desk_user->save();

    $this->assertTrue($this->front_desk_user->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('frontdeskusers.suspend', $this->front_desk_user))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been suspend and they can no longer login.');

    $this->assertFalse($this->front_desk_user->refresh()->is_active);
  }

  public function test_super_admin_can_unsuspend_front_desk_user()
  {
    $this->front_desk_user->is_active = false;
    $this->front_desk_user->save();

    $this->assertFalse($this->front_desk_user->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('frontdeskusers.unsuspend', $this->front_desk_user))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been restored and they can login once again.');

    $this->assertTrue($this->front_desk_user->refresh()->is_active);
  }

  public function test_super_admin_can_activate_front_desk_user_account()
  {
    $this->set_user_props(false,false);

    $this->assertFalse($this->front_desk_user->isAccountActivated());

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('frontdeskusers.activate', $this->front_desk_user))
      ->assertRedirect(route('frontdeskusers.list'))
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'User account has been activated and they have received a notification mail.');

    $this->assertTrue($this->front_desk_user->refresh()->isAccountActivated());

  }

  public function test_super_admin_can_delete_front_desk_user_accounts()
  {

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->delete(route('frontdeskusers.delete', $this->front_desk_user))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account and all their records deleted.');

    $this->assertDeleted($this->front_desk_user);

  }

  public function test_super_admin_can_view_nurses()
  {
    Nurse::factory()->count(20)->create();

    $rsp = $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->get(route('nurses.index'))->assertOk();

    $rsp->assertInertia(fn(Assert $page) => $page
      ->component('SuperAdmin::ManageUsers', false)

      ->has('nurses', 20, fn($page) => $page
        ->missing('created_at')
        ->etc()
      )
    );
  }

  public function test_super_admin_can_create_nurses()
  {
    $this->assertDatabaseCount('nurses', 0);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->post(route('nurses.create'),[
      'name' => 'Hello',
      'email' => 'hello@example.com',
      'password' => 'P@$$w0rd',
      'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ])
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Nurse account created. Activate the account so the user can login.');

      $this->assertDatabaseCount('nurses', 1);

      $user = Nurse::latest('id')->first();

      $this->assertEquals('Hello', $user->name);
      $this->assertFalse($user->isAccountActivated());
      $this->assertTrue($user->is_active);
  }

  public function test_super_admin_can_suspend_nurse()
  {
    $nurse = Nurse::factory()->active()->create();

    $this->assertTrue($nurse->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('nurses.suspend', $nurse))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been suspend and they can no longer login.');

    $this->assertFalse($nurse->refresh()->is_active);
  }

  public function test_super_admin_can_unsuspend_nurse()
  {
    $nurse = Nurse::factory()->create();

    $this->assertFalse($nurse->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('nurses.unsuspend', $nurse))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been restored and they can login once again.');

    $this->assertTrue($nurse->refresh()->is_active);
  }

  public function test_super_admin_can_activate_nurse_account()
  {
    $nurse = Nurse::factory()->create();

    $this->assertFalse($nurse->isAccountActivated());

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('nurses.activate', $nurse))
      ->assertRedirect(route('nurses.index'))
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'User account has been activated and they have received a notification mail.');

    $this->assertTrue($nurse->refresh()->isAccountActivated());

  }

  public function test_super_admin_can_delete_nurse_accounts()
  {
    $nurse = Nurse::factory()->create();

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->delete(route('nurses.delete', $nurse))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account and all their records deleted.');

    $this->assertDeleted($nurse);

  }

  public function test_super_admin_can_view_doctors()
  {
    Doctor::factory()->count(20)->create();

    $rsp = $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->get(route('doctors.index'))->assertOk();

    $rsp->assertInertia(fn(Assert $page) => $page
      ->component('SuperAdmin::ManageUsers', false)

      ->has('doctors', 20, fn($page) => $page
        ->missing('created_at')
        ->etc()
      )
    );
  }

  public function test_super_admin_can_create_doctors()
  {
    $this->assertDatabaseCount('doctors', 0);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->post(route('doctors.create'),[
      'name' => 'Hello',
      'email' => 'hello@example.com',
      'password' => 'P@$$w0rd',
      'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ])
      ->assertRedirect()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Doctor account created. Activate the account so the user can login.');

      $this->assertDatabaseCount('doctors', 1);

      $user = Doctor::latest('id')->first();

      $this->assertEquals('Hello', $user->name);
      $this->assertFalse($user->isAccountActivated());
      $this->assertTrue($user->is_active);
  }

  public function test_super_admin_can_suspend_doctor()
  {
    $doctor = Doctor::factory()->active()->create();

    $this->assertTrue($doctor->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('doctors.suspend', $doctor))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been suspend and they can no longer login.');

    $this->assertFalse($doctor->refresh()->is_active);
  }

  public function test_super_admin_can_unsuspend_doctor()
  {
    $doctor = Doctor::factory()->create();

    $this->assertFalse($doctor->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('doctors.unsuspend', $doctor))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been restored and they can login once again.');

    $this->assertTrue($doctor->refresh()->is_active);
  }

  public function test_super_admin_can_activate_doctor_account()
  {
    $doctor = Doctor::factory()->create();

    $this->assertFalse($doctor->isAccountActivated());

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('doctors.activate', $doctor))
      ->assertRedirect(route('doctors.index'))
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'User account has been activated and they have received a notification mail.');

    $this->assertTrue($doctor->refresh()->isAccountActivated());

  }

  public function test_super_admin_can_delete_doctor_accounts()
  {
    $doctor = Doctor::factory()->create();

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->delete(route('doctors.delete', $doctor))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account and all their records deleted.');

    $this->assertDeleted($doctor);

  }
}
