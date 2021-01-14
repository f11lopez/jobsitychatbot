<?php

namespace App\Http\Controllers;

use App\Models\Currency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use App\Lib\dBug;

class TestController extends Controller
{
  protected $apiKey = false;
  protected $endpoint_usage = 'https://free.currconv.com/others/usage';  
  protected $endpoint_currencies = 'https://free.currconv.com/api/v7/currencies';
  protected $endpoint_countries = 'https://free.currconv.com/api/v7/countries';
  protected $endpoint_convert = 'https://free.currconv.com/api/v7/convert';
  
  /**
   * Connects to the API to retrieve all available currencies and inserts them into the database
   *
   * @return array or false
  */
  public function getAvailableCurrencies($save = false)
  {
    //$url_countries = $this->endpoint_countries.'?apiKey='.$this->apiKey;
    //$aResponseCountries = Http::get($url_countries)->json()['results'];
    $this->apiKey = env('CURRCONV_API_KEY', false);
    $url = "{$this->endpoint_currencies}?apiKey={$this->apiKey}";
    $aResponseCurrencies = Http::get($url)->json()['results'];
    $aData2Save = array();
    foreach($aResponseCurrencies as $code => $aDetails) {
      $aData = array(
        'code' => $code,
        'symbol' => isset($aDetails['currencySymbol']) ? $aDetails['currencySymbol'] : '',
        'description' => $aDetails['currencyName']
      );
      array_push($aData2Save,$aData);
    }
    if ($save) Currency::insert($aData2Save);
  }
  
  public function getCurrencyConversion($amount=100, $base_currency='USD', $target_currency='CLP')
  {
    $this->apiKey = env('CURRCONV_API_KEY', false);
    $base_currency = urlencode($base_currency);
    $target_currency = urlencode($target_currency);
    $query = "{$base_currency}_{$target_currency}";
    $url = "{$this->endpoint_convert}?q={$query}&compact=ultra&apiKey={$this->apiKey}";
    $aResponse = Http::get($url)->json();
    //success
    if ( isset($aResponse[$query]) ) {
      return number_format($aResponse[$query] * $amount, 2, '.', '');
    }
    //failure
    else {
      return false;
    }
  }
  
  public function checkEmail($email = 'i@a.com')
  {
    
    //return
    $a = (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? false : true;
    
    dd($a);
    exit(0);
  }
  
  public function authenticate($email = 'i@a.com', $password="000")
  {
    $credentials = [
      'email' => $email,
      'password' => $password
    ];
    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      new dBug($user->id);
      new dBug($user->name);
      new dBug($user->email);
      var_dump($user);
    }
    else
      new dBug('nop');

    exit(0);
  }
  

} //class