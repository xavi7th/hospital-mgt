<?php

namespace App\Modules\FrontDeskUser\Tests\Feature;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
  use RefreshDatabase;

  public function test_email_can_be_verified()
  {
    $this->front_desk_user-> verified_at = null;

    /**
     * ? Verification Screen can be rendered
     */
    $rsp = $this->actingAs($this->front_desk_user)->get('/verify-email')->assertStatus(200);

    $page = $this->getResponseData($rsp);
    $this->assertEquals('UserAuth::VerifyEmail', $page->component);


    /**
     * ? Email cannot be verified with invalid hash
     */
    $verificationUrl = URL::temporarySignedRoute('auth.verification.verify', now()->addMinutes(60),[
      'id' => $this->front_desk_user->id, 'hash' => sha1('wrong-email')
    ]);

    $this->actingAs($this->front_desk_user)->get($verificationUrl);

    $this->assertFalse($this->front_desk_user->fresh()->hasVerifiedEmail());

    /**
     * ? Email can be verified
     */

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute('auth.verification.verify',now()->addMinutes(60),[
      'id' => $this->front_desk_user->id, 'hash' => sha1($this->front_desk_user->email)
    ]);

    $this->actingAs($this->front_desk_user)->get($verificationUrl)->assertRedirect($this->front_desk_user->dashboardRoute().'?verified=1');

    Event::assertDispatched(Verified::class);
    $this->assertTrue($this->front_desk_user->fresh()->hasVerifiedEmail());
  }

}
