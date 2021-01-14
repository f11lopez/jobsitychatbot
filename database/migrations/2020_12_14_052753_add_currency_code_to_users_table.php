<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyCodeToUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
  */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('currency_code')->default('USD');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
  */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('currency_code');
    });
  }

} //class