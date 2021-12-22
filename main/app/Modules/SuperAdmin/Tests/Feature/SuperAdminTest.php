<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\Assert;

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

  public function test_super_admin_can_view_fornt_desk_users()
  {
    $rsp = $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->get(route('frontdeskusers.list'))->assertOk();

    $rsp->assertInertia(fn(Assert $page) => $page
      ->component('FrontDeskUser::ManageFrontDeskUsers', false)
      ->has('fornt_desk_users', 1)
    );
  }

  public function test_super_admin_can_suspend_fornt_desk_user()
  {
    $this->fornt_desk_user->is_active = true;
    $this->fornt_desk_user->save();

    $this->assertTrue($this->fornt_desk_user->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('frontdeskusers.suspend', $this->fornt_desk_user))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been suspend and they can no longer login.');

    $this->assertFalse($this->fornt_desk_user->refresh()->is_active);
  }

  public function test_super_admin_can_unsuspend_fornt_desk_user()
  {
    $this->fornt_desk_user->is_active = false;
    $this->fornt_desk_user->save();

    $this->assertFalse($this->fornt_desk_user->is_active);

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('frontdeskusers.unsuspend', $this->fornt_desk_user))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account has been restored and they can login once again.');

    $this->assertTrue($this->fornt_desk_user->refresh()->is_active);
  }

  public function test_super_admin_can_activate_fornt_desk_user_account()
  {
    $this->set_user_props(false,false,false,false);

    $this->assertFalse($this->fornt_desk_user->isActivated());

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->put(route('frontdeskusers.activate', $this->fornt_desk_user))
      ->assertRedirect(route('frontdeskusers.list'))
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'User account has been activated and they have received a notification mail.');

    $this->assertTrue($this->fornt_desk_user->refresh()->isActivated());

  }

  public function test_super_admin_can_delete_fornt_desk_user_accounts()
  {

    $this->actingAs($this->super_admin, $this->getAuthGuard($this->super_admin))->delete(route('frontdeskusers.delete', $this->fornt_desk_user))
    ->assertRedirect()
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertSessionHas('flash.success', 'User account and all their records deleted.');

    $this->assertDeleted($this->fornt_desk_user);

  }
}
