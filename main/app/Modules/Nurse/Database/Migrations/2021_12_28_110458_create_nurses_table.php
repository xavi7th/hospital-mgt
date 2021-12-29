<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNursesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('nurses', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password');
      $table->string('avatar_url')->nullable();
      $table->timestamp('account_activated_at')->nullable();
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
    Schema::dropIfExists('nurses');
  }
}
