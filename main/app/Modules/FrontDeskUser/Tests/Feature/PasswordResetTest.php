<?php

namespace App\Modules\FrontDeskUser\Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
  use RefreshDatabase;

  public function test_front_desk_user_can_reset_password()
  {
    /**
    * ? Password reset screen can be seen
    */
    $rsp = $this->get(route('auth.password.request'))->assertStatus(200);

    $page = $this->getResponseData($rsp);
    $this->assertEquals('UserAuth::ForgotPassword', $page->component);

    /**
    * ? Password request link can be requested
    */
    Notification::fake();

    $this->post(route('auth.password.email'), ['email' => $this->front_desk_user->email]);

    Notification::assertSentTo($this->front_desk_user, ResetPassword::class, function ($notification) {
      /**
      * ? After that reset password screen can be visited
      */
      $rsp = $this->get(route('auth.password.reset', $notification->token))->assertStatus(200);
      $page = $this->getResponseData($rsp);
      $this->assertEquals('UserAuth::ResetPassword', $page->component);
      $this->assertArrayHasKey('request', (array)$page->props);


      /**
      * ? After that password can be reset with valid token
      */
     $this->post('/reset-password', [
        'token' => $notification->token,
        'email' => $this->front_desk_user->email,
        'password' => 'password',
        'password_confirmation' => 'password',
      ])->assertSessionHasNoErrors();

      return true;
    });
  }

}
