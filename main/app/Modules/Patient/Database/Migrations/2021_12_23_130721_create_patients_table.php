<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('patients', function (Blueprint $table) {
      $table->id();
      $table->string('email')->nullable()->unique();
      $table->string('phone')->unique();
      $table->string('name');
      $table->string('avatar_url');
      $table->date('date_of_birth');
      $table->string('next_of_kin');
      $table->string('next_of_kin_phone');

      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('patients');
  }
}
