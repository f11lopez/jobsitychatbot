<?php

namespace App\Traits;

use App\Models\Transaction;


trait TransactionTrait {
  
  /**
   * Deposits money into users's account
   *
   * @return array or false
  */
  public function addTransaction($user_id, $base_currency, $target_currency, $transaction_type, $amount)
  {
    //$amount = number_format(floatval($amount), 2, '.', '');
    return Transaction::create([
      'user_id' => $user_id,
      'base_currency' => $base_currency,
      'target_currency' => $target_currency,
      'transaction_type' => $transaction_type,
      'amount' => $amount
    ]);
    //$aReturn['amount'] = number_format($aReturn['amount'], 2, '.', ',');
    //return $aReturn;
  }
  
  /**
   * Check if enough balance to perform the withdraw
   *
   * @return true or false
  */
  protected function checkIfEnoughBalance($user_id, $amount)
  {
    $nBalance = $this->getAccountBalance($user_id);
    $nWithdraw = number_format($amount, 2, '.', '');
    return ($nBalance >= $nWithdraw ) ? true : false;
  }
  
  /**
   * Show current account balance
   *
   * @return number or false
  */
  public function getAccountBalance($user_id, $data=false)
  {
    $nBalance = Transaction::where('user_id', $user_id)->sum('amount');
    if (!is_null($nBalance)) {
      if ($data) {
        $oTransaction = $this->addTransaction($user_id, $data['base_currency'], $data['target_currency'], $data['transaction_type'], 0);
      }
      return number_format($nBalance, 2, '.', '');
    }
    else {
      return false;
    }
  }
  
} //trait