<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
  use RefreshDatabase;

  public function test_front_desk_user_can_confirm_password()
  {
    /**
    * ? Password confirmation screen can be visited
    */
    $rsp = $this->actingAs($this->front_desk_user)->get(route('auth.password.confirm'))->assertStatus(200);

    $page = $this->getResponseData($rsp);

    $this->assertEquals('UserAuth::ConfirmPassword', $page->component);

    /**
     * ? Password cannot be confirmed with wrong password
     */
    $this->actingAs($this->front_desk_user)->post(route('auth.password.confirm'), ['password' => 'wrong-password',])
      ->assertSessionHasErrors('password', 'The provided password is incorrect.');

    /**
     * ? Password can be confirmed with right password
     */

    $this->actingAs($this->front_desk_user)->post(route('auth.password.confirm'), ['password' => 'pass'])
      ->assertRedirect()
      ->assertSessionHasNoErrors();
  }
}
