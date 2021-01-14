<?php

namespace App\Http\Controllers\Chatbot;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Auth;

use App\Traits\CurrencyTrait;
use App\Traits\TransactionTrait;


class TransactionConversation extends Conversation
{
  use CurrencyTrait;
  use TransactionTrait;
  
  protected $is_user_authenticated = false;
  protected $user_id;
  protected $user_name;
  
  protected $transaction_type;
  protected $amount = 0;
  protected $user_currency_code;
  protected $user_currency_desc;
  protected $base_currency_code;
  protected $base_currency_desc;
  
  public function __construct($transaction_type) {
    $this->transaction_type = $transaction_type;
    // Always check the user is logged in...
    if (Auth::check()) {
      $this->is_user_authenticated = true;
      $oUser = Auth::user();
      $this->user_id = $oUser->id;
      $this->user_name = $oUser->name;
      $this->user_currency_code = $oUser->currency_code;
      $this->user_currency_desc = $this->getCurrencyByCode(strtoupper(trim($oUser->currency_code)))['description'];
      $this->base_currency_code = $this->user_currency_code;
      $this->base_currency_desc = $this->user_currency_desc;
    }
  }
  
  /**
   * Start the conversation
  */
  public function run()
  {    
    switch ($this->transaction_type) {
      case 'Deposit':
        $this->depositConversation();
        break;
      case 'Withdraw':
        $this->withdrawConversation();
        break;
      case 'Show':
        $this->balanceConversation();
        break;
      case 'All':
        $this->allConversation();
        break;        
    }
  }
  
  /****************************
   * Deposit Conversation
  ****************************/
  protected function depositConversation()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $this->ask("Hi {$this->user_name}, what's the amount you want to deposit?", function ($answer) {
        $amount = $answer->getText();
        if (!is_numeric(trim($amount)) || (is_numeric(trim($amount)) && $amount<=0))
          return $this->repeat("<strong style='color:red'>{$amount}</strong> is not a valid amount. <strong>Please provide the amount you want to deposit.</strong>",['parse_mode' => 'HTML']);
        //$this->amount = number_format($amount, 2, '.', ',');
        $this->amount = $amount;
        $this->checkIfConversionNeeded();
      });
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }
  
  protected function checkIfConversionNeeded()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $question = Question::create("Your account is set in {$this->user_currency_desc}, is your deposit also in {$this->user_currency_desc}?")
        ->fallback('Unable to make the deposit')
        ->callbackId('check_conversion')
        ->addButtons([
          Button::create('Yes')->value('YES'),
          Button::create('No')->value('NO')
        ]);
      $this->ask($question, function (Answer $answer) {
        // Button was clicked:
        if ($answer->isInteractiveMessageReply()) {
          switch ($answer->getValue()) {
            case 'YES':
              $this->confirmDeposit();
              break;
            case 'NO':
              $this->askBaseCurrency();
              break;
          }
        }
        // Answer was written:
        else {
          switch (strtoupper(trim($answer->getText()))) {
            case 'YES':
              $this->confirmDeposit();
              break;
            case 'NO':
              $this->askBaseCurrency();
              break;
            default:
              return $this->repeat();
          }
        }
      });
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }
  
  protected function askBaseCurrency()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $this->ask("What's the <strong>code</strong> of the currency you want to deposit?", function ($answer) {
        $base_currency_code = $answer->getText();
        $aBaseCurrency = $this->getCurrencyByCode(strtoupper(trim($base_currency_code)));
        if (!$aBaseCurrency)
          return $this->repeat("<strong style='color:red'>{$base_currency_code}</strong> is not a valid currency code. <strong>Please provide the code of the currency you want to deposit.</strong>",['parse_mode' => 'HTML']);
        $this->base_currency_code = $aBaseCurrency['code'];
        $this->base_currency_desc = $aBaseCurrency['description'];
        $this->say("Converting <strong>{$this->amount} {$this->base_currency_desc}</strong> to <strong>{$this->user_currency_desc}</strong>",['parse_mode' => 'HTML']);
        $conversion = $this->getCurrencyConversion($this->amount, $this->base_currency_code, $this->user_currency_code);
        if ($conversion) {
          $this->say("<strong>{$this->amount} {$this->base_currency_desc}</strong> are <strong>{$conversion} {$this->user_currency_desc}</strong>",['parse_mode' => 'HTML']);
          //$this->amount = number_format($conversion, 2, '.', ',');
          $this->amount = $conversion;
          $this->confirmDeposit();
        }        
        else
          $this->say("Error trying to perform the currency conversion. Please try again");
      });
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }
  
  protected function confirmDeposit()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $question = Question::create("Do you confirm to deposit {$this->amount} {$this->user_currency_desc}, into your account?")
        ->fallback('Unable to make the deposit')
        ->callbackId('confirm_deposit')
        ->addButtons([
          Button::create('Yes')->value('YES'),
          Button::create('No')->value('NO')
        ]);
      $this->ask($question, function (Answer $answer) {
        // Button was clicked:
        if ($answer->isInteractiveMessageReply()) {
          switch ($answer->getValue()) {
            case 'YES':
              $oDeposit = $this->addTransaction($this->user_id, $this->base_currency_code, $this->user_currency_code, $this->transaction_type, $this->amount);
              $oDate = date_create($oDeposit->created_at);
              $sDate = date_format($oDate, 'g:ia e \o\n l jS F Y');
              $this->say("{$oDeposit->target_currency} {$oDeposit->amount} have been added into your account at {$sDate}");
              break;
            case 'NO':
              $this->say("Deposit canceled. Thank you!");
              break;
          }
        }
        // Answer was written:
        else {
          switch (strtoupper(trim($answer->getText()))) {
            case 'YES':
              $oDeposit = $this->addTransaction($this->user_id, $this->base_currency_code, $this->user_currency_code, $this->transaction_type, $this->amount);
              $oDate = date_create($oDeposit->created_at);
              $sDate = date_format($oDate, 'g:ia e \o\n l jS F Y');
              $this->say("{$oDeposit->target_currency} {$oDeposit->amount} have been added into your account at {$sDate}");
              break;
            case 'NO':
              $this->say("Deposit canceled. Thank you!");
              break;
            default:
              return $this->repeat();
          }
        }
      });
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }
  
  /****************************
   * Withdraw Conversation
  ****************************/  
  protected function withdrawConversation()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $this->ask("Hi {$this->user_name}, what's the amount you want to withdraw in {$this->user_currency_desc}?", function ($answer) {
        $amount = $answer->getText();
        if (!is_numeric(trim($amount)) || (is_numeric(trim($amount)) && $amount<=0))
          return $this->repeat("<strong style='color:red'>{$amount}</strong> is not a valid amount. <strong>Please provide the amount you want to withdraw in {$this->user_currency_desc}.</strong>",['parse_mode' => 'HTML']);
        //$this->amount = number_format($amount, 2, '.', ',');
        $this->amount = $amount;
        if ($this->checkIfEnoughBalance($this->user_id, $this->amount))
          $this->confirmWithdraw();
        else
          return $this->repeat("The amount <strong style='color:red'>{$this->amount}</strong> exceeds the remaining balance on your account. <strong>Type \"balance\" to check.</strong> What's the amount you want to withdraw in {$this->user_currency_desc}?",['parse_mode' => 'HTML']);
      });
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }
  
  protected function confirmWithdraw()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $question = Question::create("Do you confirm to withdraw {$this->amount} {$this->user_currency_desc}, from your account?")
        ->fallback('Unable to make the withdraw')
        ->callbackId('confirm_withdraw')
        ->addButtons([
          Button::create('Yes')->value('YES'),
          Button::create('No')->value('NO')
        ]);
      $this->ask($question, function (Answer $answer) {
        // Button was clicked:
        if ($answer->isInteractiveMessageReply()) {
          switch ($answer->getValue()) {
            case 'YES':
              $oWithdraw = $this->addTransaction($this->user_id, $this->base_currency_code, $this->user_currency_code, $this->transaction_type, $this->amount*-1);
              $oWithdraw->amount = $oWithdraw->amount*-1;
              $oDate = date_create($oWithdraw->created_at);
              $sDate = date_format($oDate, 'g:ia e \o\n l jS F Y');
              $this->say("{$oWithdraw->target_currency} {$oWithdraw->amount} have been withdrawn from your account at {$sDate} <strong>Type \"balance\" to check.</strong>");
              break;
            case 'NO':
              $this->say("Withdraw canceled. Thank you!");
              break;
          }
        }
        // Answer was written:
        else {
          switch (strtoupper(trim($answer->getText()))) {
            case 'YES':
              $oWithdraw = $this->addTransaction($this->user_id, $this->base_currency_code, $this->user_currency_code, $this->transaction_type, $this->amount*-1);
              $oWithdraw->amount = $oWithdraw->amount*-1;
              $oDate = date_create($oWithdraw->created_at);
              $sDate = date_format($oDate, 'g:ia e \o\n l jS F Y');
              $this->say("{$oWithdraw->target_currency} {$oWithdraw->amount} have been withdrawn from your account at {$sDate} <strong>Type \"balance\" to check.</strong>");
              break;
            case 'NO':
              $this->say("Withdraw canceled. Thank you!");
              break;
            default:
              return $this->repeat();
          }
        }
      });
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }
  
  /****************************
   * Balance Conversation
  ****************************/  
  protected function balanceConversation()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $data = array(
        'user_id' => $this->user_id,
        'base_currency' => $this->base_currency_code,
        'target_currency' => $this->user_currency_code,
        'transaction_type' => $this->transaction_type,
        'amount' => $this->amount
      );
      $nBalance = $this->getAccountBalance($this->user_id, $data);
      $this->say("Your account balance is <strong>{$nBalance}<strong> {$this->user_currency_desc}",['parse_mode' => 'HTML']);
      return false;
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }
  
  /****************************
   * All Conversation
  ****************************/
  protected function allConversation()
  {
    // Always check the user is logged in...
    if ($this->is_user_authenticated) {
      $question = Question::create("Please select the transaction you would like to do:")
        ->fallback('Unable to make the transaction')
        ->callbackId('confirm_transaction')
        ->addButtons([
          Button::create('Deposit')->value('DEPOSIT'),
          Button::create('Withdraw')->value('WITHDRAW'),
          Button::create('Balance')->value('BALANCE')
        ]);
      $this->ask($question, function (Answer $answer) {
        // Button was clicked:
        if ($answer->isInteractiveMessageReply()) {
          switch ($answer->getValue()) {
            case 'DEPOSIT':
              $this->transaction_type = 'Deposit';
              $this->depositConversation();
              break;
            case 'WITHDRAW':
              $this->transaction_type = 'Withdraw';
              $this->withdrawConversation();
              break;
            case 'BALANCE':
              $this->transaction_type = 'Show';
              $this->balanceConversation();
              break;
          }
        }
        // Answer was written:
        else {
          switch (strtoupper(trim($answer->getText()))) {
            case 'DEPOSIT':
              $this->transaction_type = 'Deposit';
              $this->depositConversation();
              break;
            case 'WITHDRAW':
              $this->transaction_type = 'Withdraw';
              $this->withdrawConversation();
              break;
            case 'BALANCE':
              $this->transaction_type = 'Show';
              $this->balanceConversation();
              break;
            default:
              return $this->repeat();
          }
        }
      });
    }
    // User is not logged in...
    else {
      $this->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
      return false;
    }
  }  
  
  
} //class