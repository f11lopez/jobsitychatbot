@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card-deck">
      <div class="card border-danger mb-2">
        <div class="card-body">
          <h5 class="card-title text-danger">Dialoged Money Transactions</h5>
          <p class="card-text">Perform a number of transactions into your account by answering the questions the Chatbot will ask you.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">balance</medium> to show the money remaining in your account.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">deposit</medium> to add money into your account.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">withdraw</medium> to retreat money from your account.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">all</medium> to get all available transactions.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">exit</medium> to quit the conversation.</p>
        </div>
        <div class="card-footer bg-transparent border-0"><p class="card-text"><small class="text-danger">You need to be logged in.</small></p></div>
      </div>
      <div class="card border-info mb-2">
        <div class="card-body">
          <h5 class="card-title text-info">Dialoged Currency Exchange</h5>
          <p class="card-text">Perform currency exchange by answering the questions the Chatbot will ask you.</p>
          <p class="card-text">Please check the list of supported currency codes below.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">convert</medium> or <medium class="font-weight-bold">exchange</medium> to start the process.</p>
          <p class="card-text mb-1">Type <medium class="font-weight-bold">exit</medium> to quit the conversation.</p>
        </div>
        <div class="card-footer bg-transparent border-0"><p class="card-text"><small class="text-info">No login needed.</small></p></div>
      </div>
      <div class="card border-success mb-2">
        <div class="card-body">
          <h5 class="card-title text-success">Straight Currency Exchange</h5>
          <p class="card-text">Perform currency exchange by providing an amount, the code of the base currency and the code of the target currency.</p>
          <p class="card-text">Please check the list of supported currency codes below.</p>
          <p class="card-text mb-1"><medium class="font-weight-bold">Command Format:</medium> {Amount} {Base Currency Code} to {Target Currency Code}</p>
          <p class="card-text mb-1"><medium class="font-weight-bold">Example:</medium> 100 USD to CLP</p>
        </div>
        <div class="card-footer bg-transparent border-0"><p class="card-text"><small class="text-success">No login needed.</small></p></div>
      </div>
    </div>
    <div class="card border-dark">
      <div class="card-body">
        <h5 class="card-title text-dark">List of Supported Currencies</h5>
        <table class="table table-hover text-dark">
          <thead>
            <tr>
              <th scope="col">Currency</th>
              <th scope="col">Description</th>
              <th scope="col">Currency</th>
              <th scope="col">Description</th>
            </tr>
          </thead>
          <tbody>
            @foreach($aCurrencies as $aCoupledCurrencies)
              <tr>
                @foreach($aCoupledCurrencies as $aCurrency)
                  <th scope="row">{{ $aCurrency['code'] }}</th>
                  <td>{{ $aCurrency['description'] }}</th>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>    
  </div>
@endsection