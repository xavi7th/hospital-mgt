<?php

namespace App\Modules\FrontDeskUser\Tests\Feature;

use Tests\TestCase;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontDeskUserTest extends TestCase
{
  use RefreshDatabase;

  public function test_app_user_can_visit_their_dashboard()
  {

    $this->set_user_props($actve = true, $terms_accepted = true, $activated = true, $id_uploaded=true);

    $rsp = $this->actingAs($this->app_user, $this->getAuthGuard($this->app_user))->get(route($this->app_user->dashboardRoute()))->assertOk();

    $rsp->assertInertia(fn (Assert $page) => $page
      ->component('FrontDeskUser::Dashboard')
      ->url('/users/dashboard')
      ->has('authuser', fn($page) => $page
        ->where('name', $this->app_user->full_name)
        ->where('cummulative_deposit_amount', 0)
        ->where('cummulative_profit_amount', 0)
        ->where('current_user_balance', 0)
        ->where('bonus_earned', 0)
        ->etc()
      )
      ->where('current_plan', false)
    );

  }

}
