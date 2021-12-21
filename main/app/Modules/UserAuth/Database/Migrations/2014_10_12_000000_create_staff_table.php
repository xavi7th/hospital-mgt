<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('staff', function (Blueprint $table) {
      $table->id();
      $table->string('email')->unique();
      $table->string('phone')->unique()->nullable();
      $table->string('password');
      $table->string('first_name');
      $table->string('last_name')->nullable();
      $table->string('address')->nullable();
      $table->string('avatar')->nullable();
      $table->string('type');
      $table->timestamp('verified_at')->nullable();
      $table->boolean('is_active')->default(true);


      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
