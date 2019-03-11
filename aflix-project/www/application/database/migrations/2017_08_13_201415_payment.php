<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Payment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('payment_settings', function (Blueprint $table) {
          $table->increments('id');
          $table->text('live_publishable_key')->nullable();
          $table->integer('live_mode')->nullable();
          $table->text('live_secret_key')->nullable();
          $table->text('test_publishable_key')->nullable();
          $table->text('test_secret_key')->nullable();
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
        Schema::drop('payment_settings');
    }
}
