<?php

namespace Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\Assert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
  public function test_login_screen_can_be_rendered()
  {
    $rsp = $this->get('/login')->assertStatus(200);

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('UserAuth::Login')
      ->url('/login')
    );

  }

  public function test_users_can_authenticate_using_the_login_screen()
  {
    $this->post('/login', ['email' => $this->front_desk_user->email,'password' => 'pass'])
      ->assertSessionMissing('flash.error')
      ->assertSessionHasNoErrors()
      ->assertRedirect(route($this->front_desk_user->dashboardRoute()));

    $this->assertAuthenticated('front_desk_user');
  }

  public function test_users_can_not_authenticate_with_invalid_password()
  {
    $this->post('/login', ['email' => $this->front_desk_user->email,'password' => 'wrong-password'])
      ->assertSessionHasErrors('email', 'These credentials do not match our records');

    $this->assertGuest();
  }
}
