<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontDeskUsersTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('front_desk_users', function (Blueprint $table) {
      $table->id();
      $table->string('email');
      $table->string('password');
      $table->string('first_name');
      $table->string('last_name');
      $table->string('phone');
      $table->string('avatar_url')->nullable();
      $table->string('account_id');
      $table->timestamp('verified_at')->nullable();
      $table->boolean('is_active')->default(true);

      $table->timestamps();
      $table->softDeletes();
      $table->rememberToken();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('front_desk_users');
  }
}
