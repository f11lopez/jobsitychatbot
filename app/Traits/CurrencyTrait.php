<?php

namespace App\Traits;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;


trait CurrencyTrait {
  
  protected $apiKey = false;
  protected $endpoint_usage = 'https://free.currconv.com/others/usage';  
  protected $endpoint_currencies = 'https://free.currconv.com/api/v7/currencies';
  protected $endpoint_countries = 'https://free.currconv.com/api/v7/countries';
  protected $endpoint_convert = 'https://free.currconv.com/api/v7/convert';
  
  /**
   * Get description of a given currency code, false if it does not exist
   *
   * @return array or false
  */
  public function getCurrencyByCode($code)
  {
    $oCurrency = Currency::where('code', $code)->first();
    return is_null($oCurrency) ? false : array('code' => $oCurrency->code, 'description' => $oCurrency->description);
  }
  
  /**
   * Connects to the API to perform currency conversion
   *
   * @return array or false
  */
  public function getCurrencyConversion($amount, $base_currency, $target_currency)
  {
    $this->apiKey = env('CURRCONV_API_KEY', false);
    $base_currency = urlencode($base_currency);
    $target_currency = urlencode($target_currency);
    $query = "{$base_currency}_{$target_currency}";
    $url = "{$this->endpoint_convert}?q={$query}&compact=ultra&apiKey={$this->apiKey}";
    $aResponse = Http::get($url)->json();
    //success
    if (isset($aResponse[$query])) {
      return number_format($aResponse[$query]*$amount, 2, '.', '');
    }
    //failure
    else {
      return false;
    }
  }

} //trait