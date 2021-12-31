<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('appointments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('patient_id');
      $table->foreignId('doctor_id');
      $table->foreignId('front_desk_user_id');
      $table->timestamp('appointment_date');
      $table->foreignId('nurse_id')->nullable();
      $table->timestamp('posted_at')->nullable();
      $table->timestamp('discharged_at')->nullable();

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
    Schema::dropIfExists('appointments');
  }
}
