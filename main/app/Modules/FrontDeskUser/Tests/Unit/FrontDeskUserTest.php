<?php

namespace App\Modules\FrontDeskUser\Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Miscellaneous\Services\MenuService;

class FrontDeskUserTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  public function setUp(): void
  {
    parent::setUp();

    Notification::fake();
  }

  /** @test  */
  public function test_front_desk_user_database_has_expected_columns()
  {
    //  dd(json_encode(Schema::getColumnListing('front_desk_user')));
    $this->assertJsonStringEqualsJsonString(
      '["id","email","password","first_name","last_name","phone","avatar_url","account_id","verified_at","is_active","created_at","updated_at","deleted_at","remember_token","country","ref_id","acc_type",
        "acc_type_color","currency","btc_wallet","id_type","id_card_thumb_url","terms_accepted_at","account_activated_at","can_withdraw","force_logout"]',
      json_encode(Schema::getColumnListing('front_desk_user'))
    );
  }

  public function test_front_desk_user_has_the_right_menu()
  {
    $menu_items = (new MenuService)->setUser($this->front_desk_user)->setHeirarchical(true)->getRoutes();

    // ray(json_encode($menu_items));

    $this->assertCount(3,$menu_items);
    $this->assertEquals('Dashboard', Arr::first($menu_items)[0]->menu_name);
    $this->assertJsonStringEqualsJsonString(
      '
       {"Dashboard":[{"uri":"users\/dashboard","name":"frontdeskusers.dashboard","nav_skip":false,"icon":"fa-user","menu_name":"Dashboard","sort_order":1,"group":"Dashboard","group_sort":1}],
        "Investments":[{"uri":"user-transactions\/investments","name":"usertransactions.investments.list","nav_skip":false,"icon":"credit-card","menu_name":"Investments","sort_order":3,"group":"Investments","group_sort":null}],
        "Withdrawals":[{"uri":"withdrawal-requests","name":"withdrawalrequests.create","nav_skip":false,"icon":"money-check-alt","menu_name":"Withdrawals","sort_order":6,"group":"Withdrawals","group_sort":null}]}',
      json_encode($menu_items)
    );
  }

  public function test_front_desk_user_has_the_right_menu_on_public_pages()
  {
    $this->actingAs($this->front_desk_user);

    $menu_items = (new MenuService)->setUser(null)->setHeirarchical(true)->getRoutes();

    // ray(json_encode($menu_items));

    $this->assertAuthenticated();
    $this->assertCount(4,$menu_items);
    $this->assertEquals('Home',Arr::first($menu_items)[0]->menu_name);
    $this->assertJsonStringEqualsJsonString(
      '{"Home":[{"uri":"\/","name":"app.home","nav_skip":false,"icon":"fa-user","menu_name":"Home","sort_order":1,"group":"Home","group_sort":1}],
      "Company":[{"uri":"about-us","name":"app.about","nav_skip":false,"icon":"fa-user","menu_name":"About Us","sort_order":2,"group":"Company",
        "group_sort":1},{"uri":"company-registration","name":"app.reg_info","nav_skip":false,"icon":"fa-user","menu_name":"Company Registration",
          "sort_order":3,"group":"Company","group_sort":1},{"uri":"investment-security","name":"app.security","nav_skip":false,"icon":"fa-user",
            "menu_name":"Investment Security","sort_order":7,"group":"Company","group_sort":1}],"Live Payout":[{"uri":"live-payouts-statistics",
              "name":"app.payouts","nav_skip":false,"icon":"fa-user","menu_name":"Live Payouts","sort_order":5,"group":"Live Payout","group_sort":1}],
              "Investment Packages":[{"uri":"available-investment-packages","name":"app.packages","nav_skip":false,"icon":"fa-user",
                "menu_name":"Investment Packages","sort_order":6,"group":"Investment Packages","group_sort":1}]}',
      json_encode($menu_items)
    );
  }
}
