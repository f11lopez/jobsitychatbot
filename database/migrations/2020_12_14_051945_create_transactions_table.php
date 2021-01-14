<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
  /**
    * Run the migrations.
    *
    * @return void
  */
  public function up()
  {
    Schema::create('transactions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('base_code')->nullable($value = true);
      $table->string('target_code')->nullable($value = true);
      $table->enum('transaction_type', ['Deposit', 'Withdraw','Show']);
      $table->decimal('amount', $precision = 15, $scale = 4);
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
    Schema::dropIfExists('transactions');
  }

} //class