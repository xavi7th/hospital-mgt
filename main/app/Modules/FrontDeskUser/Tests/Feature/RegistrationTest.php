<?php

namespace App\Modules\FrontDeskUser\Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Inertia\Testing\Assert;
use Illuminate\Http\UploadedFile;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
  use RefreshDatabase;

  public function test_a_new_user_can_be_registered()
  {
    Notification::fake();

    $rsp = $this->get(route('auth.register'))->assertStatus(200);

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('UserAuth::Register')
      ->url('/register')
    );

    $this->assertDatabaseCount('app_users', 1);

    $rsp = $this->post(route('auth.register'), [
      'email' => $this->faker->email(),
      'password' => $password = $this->faker->password(12),
      'password_confirmation' => $password,
      'first_name' => $this->faker->firstName(),
      'last_name' => $this->faker->lastName(),
      'phone' => $this->faker->e164PhoneNumber(),
      'avatar' => UploadedFile::fake()->image('id_card.jpg'),
      'country' => $this->faker->countryCode(),
      'acc_type' => null,
      'acc_type_color' => null,
      'currency' => $this->faker->currencyCode(),
    ])
    ->assertSessionHasNoErrors()
    ->assertSessionMissing('flash.error')
    ->assertRedirect(route('auth.login'))
    ->assertSessionHas('flash.success', 'Account created. A verification link has been sent to your email. Click the link to verify your account.');

    $this->assertGuest();

    Notification::assertSentTo(FrontDeskUser::latest('id')->first(), VerifyEmail::class);

    /**
     * ? Test avatar main image can be gotten
     */
    $user = FrontDeskUser::latest('id')->first();
    $this->assertEquals(Str::replaceFirst('thumbs/', '', $user->avatar_url), $user->img_url);

  }
}
