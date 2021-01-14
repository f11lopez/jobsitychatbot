<?php

namespace App\Http\Controllers\Chatbot;

use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Traits\CurrencyTrait;


class CurrencyConversation extends Conversation
{
  
  use CurrencyTrait;
  
  protected $amount;
  protected $base_currency_code;
  protected $base_currency_desc;
  protected $target_currency_code;
  protected $target_currency_desc;
  
  public function __construct($amount, $base_currency, $target_currency) {
    $this->amount = trim($amount);
    $this->base_currency_code = trim($base_currency);
    $this->target_currency_code = trim($target_currency);
  }
  
  /**
   * Start the conversation
  */
  public function run()
  {
    //Run dialogued currency conversion
    if (!$this->amount && !$this->base_currency_code && !$this->target_currency_code) {
      $this->ask("What's the <strong>amount</strong> you want to convert?", function ($answer) {
        $amount = $answer->getText();
        if (!is_numeric(trim($amount)) || (is_numeric(trim($amount)) && $amount<=0))
          return $this->repeat("<strong style='color:red'>{$amount}</strong> is not a valid amount. <strong>Please provide the amount you want to convert.</strong>",['parse_mode' => 'HTML']);
        $this->amount = trim($amount);
        $this->askBaseCurrency();
      });
    }
    //Run straight currency conversion
    else
      $this->runConversion($this->amount, $this->base_currency_code, $this->target_currency_code);
  }
  
  protected function askBaseCurrency()
  {
    $this->ask("What's the <strong>code</strong> of the currency you want to convert?", function ($answer) {
      $base_currency_code = $answer->getText();
      $aBaseCurrency = $this->getCurrencyByCode(strtoupper(trim($base_currency_code)));
      if (!$aBaseCurrency)
        return $this->repeat("<strong style='color:red'>{$base_currency_code}</strong> is not a valid currency code. <strong>Please provide the code of the currency you want to convert.</strong>",['parse_mode' => 'HTML']);
      $this->base_currency_code = $aBaseCurrency['code'];
      $this->base_currency_desc = $aBaseCurrency['description'];
      $this->askTargetCurrency();
    });
  }
  
  protected function askTargetCurrency()
  {
    $this->ask("What's the <strong>code</strong> of the currency you want as target?", function ($answer) {
      $target_currency_code = $answer->getText();
      $aTargetCurrency = $this->getCurrencyByCode(strtoupper(trim($target_currency_code)));
      if (!$aTargetCurrency)
        return $this->repeat("<strong style='color:red'>{$target_currency_code}</strong> is not a valid currency code. <strong>Please provide the code of the currency you want as target.</strong>",['parse_mode' => 'HTML']);
      $this->target_currency_code = $aTargetCurrency['code'];
      $this->target_currency_desc = $aTargetCurrency['description'];
      $this->say("Converting <strong>{$this->amount} {$this->base_currency_desc}</strong> to <strong>{$this->target_currency_desc}</strong>",['parse_mode' => 'HTML']);
      $conversion = $this->getCurrencyConversion($this->amount, $this->base_currency_code, $this->target_currency_code);
      if ($conversion)
        $this->say("<strong>{$this->amount} {$this->base_currency_desc}</strong> are <strong>{$conversion} {$this->target_currency_desc}</strong>",['parse_mode' => 'HTML']);
      else
        $this->say("Error trying to perform the currency conversion. Please try again");
    });
  }
  
  protected function runConversion($amount, $base_currency, $target_currency)
  {
    $bAmount = (!is_numeric(trim($amount)) || (is_numeric(trim($amount)) && $amount<=0)) ? false : true;
    $aBaseCurrency = $this->getCurrencyByCode(strtoupper(trim($base_currency)));
    $aTargetCurrency = $this->getCurrencyByCode(strtoupper(trim($target_currency)));
    //1. 0-0-0
    if (!$bAmount && !$aBaseCurrency && !$aTargetCurrency) {
      $this->say("<strong style='color:red'>{$amount}</strong> is not a valid amount. <strong>Please provide the amount you want to convert.</strong>",['parse_mode' => 'HTML']);
      $this->say("<strong style='color:red'>{$base_currency}</strong> is not a valid currency code to use as base. <strong>Please provide the code of the currency you want to convert.",['parse_mode' => 'HTML']);
      $this->say("<strong style='color:red'>{$target_currency}</strong> is not a valid currency code to use as target. <strong>Please provide the code of the currency you want as target.</strong>",['parse_mode' => 'HTML']);
    }
    //2. 1-0-0
    else if ($bAmount && !$aBaseCurrency && !$aTargetCurrency) {
      $this->say("<strong style='color:red'>{$base_currency}</strong> is not a valid currency code to use as base. <strong>Please provide the code of the currency you want to convert.",['parse_mode' => 'HTML']);
      $this->say("<strong style='color:red'>{$target_currency}</strong> is not a valid currency code to use as target. <strong>Please provide the code of the currency you want as target.</strong>",['parse_mode' => 'HTML']);
    }
    //3. 1-0-1
    else if ($bAmount && !$aBaseCurrency && $aTargetCurrency) {
      $this->say("<strong style='color:red'>{$base_currency}</strong> is not a valid currency code to use as base. <strong>Please provide the code of the currency you want to convert.",['parse_mode' => 'HTML']);
    }
    //4. 1-1-0
    else if ($bAmount && $aBaseCurrency && !$aTargetCurrency) {
      $this->say("<strong style='color:red'>{$target_currency}</strong> is not a valid currency code to use as target. <strong>Please provide the code of the currency you want as target.</strong>",['parse_mode' => 'HTML']);
    }
    //5. 0-0-1
    else if (!$bAmount && !$aBaseCurrency && $aTargetCurrency) {
      $this->say("<strong style='color:red'>{$amount}</strong> is not a valid amount. <strong>Please provide the amount you want to convert.</strong>",['parse_mode' => 'HTML']);
      $this->say("<strong style='color:red'>{$base_currency}</strong> is not a valid currency code to use as base. <strong>Please provide the code of the currency you want to convert.",['parse_mode' => 'HTML']);
    }      
    //6. 0-1-0
    else if (!$bAmount && $aBaseCurrency && !$aTargetCurrency) {
      $this->say("<strong style='color:red'>{$amount}</strong> is not a valid amount. <strong>Please provide the amount you want to convert.</strong>",['parse_mode' => 'HTML']);
      $this->say("<strong style='color:red'>{$target_currency}</strong> is not a valid currency code to use as target. <strong>Please provide the code of the currency you want as target.</strong>",['parse_mode' => 'HTML']);
    }
    //7. 0-1-1
    else if (!$bAmount && $aBaseCurrency && $aTargetCurrency) {
      $this->say("<strong style='color:red'>{$amount}</strong> is not a valid amount. <strong>Please provide the amount you want to convert.</strong>",['parse_mode' => 'HTML']);
    }
    //8. 1-1-1
    else {
      $this->say("Converting <strong>{$amount} {$aBaseCurrency['description']}</strong> to <strong>{$aTargetCurrency['description']}</strong>",['parse_mode' => 'HTML']);
      $conversion = $this->getCurrencyConversion($amount, $aBaseCurrency['code'], $aTargetCurrency['code']);
      if ($conversion)
        $this->say("<strong>{$amount} {$aBaseCurrency['description']}</strong> are <strong>{$conversion} {$aTargetCurrency['description']}.</strong>",['parse_mode' => 'HTML']);
      else
        $this->say('Error trying to perform the currency conversion. Please try again');
    }
  }
  
} //class