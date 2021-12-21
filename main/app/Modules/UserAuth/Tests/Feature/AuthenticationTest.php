<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
  use RefreshDatabase;

  public function test_login_screen_can_be_rendered()
  {
    $rsp = $this->get('/login')->assertStatus(200);

    $page = $this->getResponseData($rsp);

    $this->assertEquals('UserAuth::Login', $page->component);
    $this->assertArrayHasKey('can_reset_password', (array)$page->props);
    $this->assertArrayHasKey('status', (array)$page->props);
  }

  public function test_users_can_authenticate_using_the_login_screen()
  {
    $this->post('/login', ['email' => $this->app_user->email,'password' => 'pass'])
      ->assertSessionMissing('flash.error')
      ->assertSessionHasNoErrors()
      ->assertRedirect(route($this->app_user->dashboardRoute()));

    $this->assertAuthenticated();
  }

  public function test_users_can_not_authenticate_with_invalid_password()
  {
    $this->post('/login', ['email' => $this->app_user->email,'password' => 'wrong-password'])
      ->assertSessionHasErrors('email', 'These credentials do not match our records');

    $this->assertGuest();
  }
}
