<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;


class ChatbotController extends Controller
{
  
  //use CurrencyTrait;
  
  /**
   * Place your BotMan logic here.
  */
  public function handle()
  {
    
    $chatbot = app('botman');
    
    //Capture straight currency request
    $chatbot->hears('{amount} {base_currency} to {target_currency}', function (BotMan $bot, $amount, $base_currency, $target_currency) {
      $bot->startConversation(new CurrencyConversation($amount, $base_currency, $target_currency));
    });
    
    //Capture dialogued currency conversion request
    $chatbot->hears('.*convert.*|.*exchange.*', function (BotMan $bot) {
      $bot->startConversation(new CurrencyConversation(false, false, false));
    });
    
    //Capture balance request
    $chatbot->hears('.*balance.*|.*show.*', function (BotMan $bot) {
      $bot->startConversation(new TransactionConversation('Show'));
    });
    
    //Capture deposit request
    $chatbot->hears('.*deposit.*', function (BotMan $bot) {
      $bot->startConversation(new TransactionConversation('Deposit'));
    });
    
    //Capture withdraw request
    $chatbot->hears('.*withdraw.*', function (BotMan $bot) {
      $bot->startConversation(new TransactionConversation('Withdraw'));
    });
    
    //Capture transaction request
    $chatbot->hears('.*all*', function (BotMan $bot) {
      $bot->startConversation(new TransactionConversation('All'));
    });
    
    //Capture quit request to abort any current conversation
    $chatbot->hears('.*quit.*|.*stop.*|.*abort.*|.*exit.*', function (BotMan $bot) {
      $bot->reply("Conversation aborted. Thank you!");
    })->stopsConversation();
    
    //Capture greetings & and show intro
    $chatbot->hears('.*hello.*|.*hi.*|.*hola.*', function (BotMan $bot) {
      $bot->reply("✋ Hi!, I can perform <strong>currency exchange</strong> or <strong> money transactions</strong> if you log in. My known commands are:",['parse_mode' => 'HTML']);
      $bot->reply("<table><tr><td><strong style='color:#e3342f'>&rarr; For Dialoged Money Transactions:</strong></td></tr><tr><td><u>Type:</u> balance, deposit, withdraw or all</td></tr><tr><td><strong style='color:#6cb2eb'>&rarr; For Dialoged Currency Exchange:</strong></td></tr><tr><td><u>Type:</u> convert or exchange</td></tr><tr><td><strong style='color:#38c172'>&rarr; For Straight Currency Exchange:</strong></td></tr><tr><td><u>Command Format:</u> {Amount} {Base Currency Code} to {Target Currency Code} <u>Example:</u>100 USD to CLP</td></tr></table>",['parse_mode' => 'HTML']);
    });    
    
    //Capture help request to get help information
    $chatbot->hears('.*help.*', function (BotMan $bot) {
      $bot->reply("<table><tr><td><strong style='color:#e3342f'>&rarr; For Dialoged Money Transactions:</strong></td></tr><tr><td><u>Type:</u> balance, deposit, withdraw or all</td></tr><tr><td><strong style='color:#6cb2eb'>&rarr; For Dialoged Currency Exchange:</strong></td></tr><tr><td><u>Type:</u> convert or exchange</td></tr><tr><td><strong style='color:#38c172'>&rarr; For Straight Currency Exchange:</strong></td></tr><tr><td><u>Command Format:</u> {Amount} {Base Currency Code} to {Target Currency Code} <u>Example:</u>100 USD to CLP</td></tr></table>",['parse_mode' => 'HTML']);
    })->skipsConversation();
    
    //Capture login request
    $chatbot->hears('.*login.*', function (BotMan $bot) {
      $bot->say("Please <strong style='color:red'>login</strong> at the top-right link that reads <strong>Login</strong>. You can also <strong>Register</strong> if you don't have an account already.",['parse_mode' => 'HTML']);
    });
    
    //Actions when chatbot does not understand the user
    $chatbot->fallback(function (BotMan $bot) {
      $bot->reply("Sorry, I don't understand <strong style='color:red'>{$bot->getMessage()->getText()}</strong>. My known commands are:");
      $bot->reply("<table><tr><td><strong style='color:#e3342f'>&rarr; For Dialoged Money Transactions:</strong></td></tr><tr><td><u>Type:</u> balance, deposit, withdraw or all</td></tr><tr><td><strong style='color:#6cb2eb'>&rarr; For Dialoged Currency Exchange:</strong></td></tr><tr><td><u>Type:</u> convert or exchange</td></tr><tr><td><strong style='color:#38c172'>&rarr; For Straight Currency Exchange:</strong></td></tr><tr><td><u>Command Format:</u> {Amount} {Base Currency Code} to {Target Currency Code} <u>Example:</u>100 USD to CLP</td></tr></table>",['parse_mode' => 'HTML']);
    });
    
    $chatbot->listen();
  }
  
} //class