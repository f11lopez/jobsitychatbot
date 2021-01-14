<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnsInTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
  */
  public function up()
  {
    Schema::table('transactions', function (Blueprint $table) {
      $table->renameColumn('base_code', 'base_currency');
      $table->renameColumn('target_code', 'target_currency');
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
      $table->renameColumn('base_currency','base_code');
      $table->renameColumn('target_currency','target_code');
    });
  }

} //class