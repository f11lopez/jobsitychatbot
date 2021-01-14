<?php
    
namespace App\Http\Controllers;

use App\Models\Currency;
    

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }
    
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index()
  {
    // Get all currencies
    $oCurrencies = Currency::orderBy('code','asc')->get();
    $aSingleCurrencies = array();
    foreach($oCurrencies as $oCurrency) {
      array_push($aSingleCurrencies,array( 'code' => $oCurrency->code,
                                           'symbol' => $oCurrency->symbol,
                                           'description' => $oCurrency->description,
                                         ));
    }
    // Organize array to display it in two columns
    $aCoupledCurrencies = array();
    for($i=0; $i<count($aSingleCurrencies); $i+=2) {
      $aTmpCurrencies = array();
      isset($aSingleCurrencies[$i]) ? array_push($aTmpCurrencies,$aSingleCurrencies[$i]) : array_push($aTmpCurrencies,array('code'=>'','description'=>''));
      isset($aSingleCurrencies[$i+1]) ? array_push($aTmpCurrencies,$aSingleCurrencies[$i+1]) : array_push($aTmpCurrencies,array('code'=>'','description'=>''));
      array_push($aCoupledCurrencies, $aTmpCurrencies);
      unset($aTmpCurrencies);
    }
    // Render the view with all available currencies
    return view( 'home.index', [ 'pageTitle' => 'Home',
                                 'aCurrencies' => $aCoupledCurrencies ] );
  }
  
} //class