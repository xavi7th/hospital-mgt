<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Fluent;
use Illuminate\Database\Connection;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Database\Schema\SQLiteBuilder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication, WithFaker;

  protected $super_admin;


  public function __construct(?string $name = null, array $data = [], string $dataName = '')
  {
    $this->hotfixSqlite();
    parent::__construct($name, $data, $dataName);
  }

  public function setUp(): void
  {
    parent::setUp();

    $this->super_admin = SuperAdmin::factory()->create();
    $this->front_desk_user = FrontDeskUser::factory()->active()->create();
  }

  /**
   * Fix for: BadMethodCallException : SQLite doesn't support dropping foreign keys (you would need to re-create the table).
   */
  public function hotfixSqlite()
  {
    Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
      return new class($connection, $database, $prefix, $config) extends SQLiteConnection
      {
        public function getSchemaBuilder()
        {
          if ($this->schemaGrammar === null) {
            $this->useDefaultSchemaGrammar();
          }
          return new class($this) extends SQLiteBuilder
          {
            protected function createBlueprint($table, \Closure $callback = null)
            {
              return new class($table, $callback) extends Blueprint
              {
                public function dropForeign($index)
                {
                  return new Fluent();
                }
              };
            }
          };
        }
      };
    });
  }

  /**
   * This function recursively converts an array into a standard class object
   *
   * @param array $array
   *
   * @return object
   */
  private function _arrayToObject($array)
  {
    return is_array($array) && !empty($array) ? (object) array_map([__CLASS__, __METHOD__], $array) : (gettype($array) == 'object' && empty((array)$array) ? null : $array);
  }

  protected function getAuthGuard(User $user): string
  {
    return Str::snake(class_basename(get_class(($user))));
  }

  protected function set_user_props($active = true, $terms_accepted = true, $activated = true, $id_uploaded = true)
  {
    $this->front_desk_user->is_active = $active;
    $this->front_desk_user->activated_at = $activated ? now() : null;
    $this->app_user->id_card_thumb_url = $id_uploaded ? $this->faker->imageUrl() : null;
    $this->app_user->save();
  }
}
