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
    // info(json_encode(Schema::getColumnListing('front_desk_users')));
    $this->assertJsonStringEqualsJsonString(
      '["id","name","email","password","avatar_url","account_activated_at","is_active","created_at","updated_at","deleted_at","remember_token"]',
      json_encode(Schema::getColumnListing('front_desk_users'))
    );
  }

  public function test_front_desk_user_has_the_right_menu()
  {
    $menu_items = (new MenuService)->setUser($this->front_desk_user)->setHeirarchical(true)->getRoutes();

    // info(json_encode($menu_items));

    $this->assertCount(2,$menu_items);
    $this->assertEquals('Dashboard', Arr::first($menu_items)[0]->menu_name);
    $this->assertJsonStringEqualsJsonString(
      '
      {
        "Dashboard":[{"uri":"frontdesk-users\/dashboard","name":"frontdeskusers.dashboard","nav_skip":false,"icon":"home","menu_name":"Dashboard","sort_order":1,"group":"Dashboard","group_sort":1}],
        "Profile":[{"uri":"frontdesk-users\/profile","name":"frontdeskusers.profile","nav_skip":false,"icon":"user","menu_name":"Profile","sort_order":8,"group":"Profile","group_sort":null}]
      }',
      json_encode($menu_items)
    );
  }

  public function test_front_desk_user_has_the_right_menu_on_public_pages()
  {
    $this->actingAs($this->front_desk_user);

    $menu_items = (new MenuService)->setUser(null)->setHeirarchical(true)->getRoutes();

    // info(json_encode($menu_items));

    $this->assertAuthenticated();
    $this->assertCount(1,$menu_items);
    $this->assertEquals('Home',Arr::first($menu_items)[0]->menu_name);
    $this->assertJsonStringEqualsJsonString(
      '{
        "Home":[{"uri":"\/","name":"app.home","nav_skip":false,"icon":"fa-user","menu_name":"Home","sort_order":1,"group":"Home","group_sort":1}]
      }',
      json_encode($menu_items)
    );
  }
}
