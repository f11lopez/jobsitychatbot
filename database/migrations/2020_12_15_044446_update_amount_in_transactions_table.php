<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAmountInTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
  */
  public function up()
  {
    Schema::table('transactions', function (Blueprint $table) {
      $table->decimal('amount', $precision = 19, $scale = 4)->change();
    });
  }
    
  /**
   * Reverse the migrations.
   *
   * @return void
  */
  public function down()
  {
    Schema::table('transactions', function (Blueprint $table) {
      $table->decimal('amount', $precision = 15, $scale = 4)->change();
    });
  }

}