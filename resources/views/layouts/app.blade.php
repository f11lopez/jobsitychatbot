<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @isset($pageTitle)
      <title>{{$pageTitle}} - JobSity Chatbot</title>
    @else
      <title>JobSity Chatbot</title>
    @endisset
    <!-- Scripts -->    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
      var botmanWidget = {
        title: 'JobSity Chatbot',
        headerTextColor: '#fff',
        aboutText: 'Powered by JobSity',
        aboutLink: 'https://www.jobsity.com/',
        introMessage: '✋ Hi!, I can perform <strong>currency exchange</strong> or <strong> money transactions</strong> if you log in. How can I help you?',
        placeholderText: "Enter your text here...",
        displayMessageTime: true,
        mainColor: '#00a4d9',
        bubbleAvatarUrl: './img/chatbot.png',
        bubbleBackground: '#fffff00',
      };
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    <div id="app">
      <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">{{ __('Home') }}</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- START Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            </ul>
            <!-- END Left Side Of Navbar -->
            <!-- START Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                @if (Route::has('login'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                @endif  
                @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
                @endif
              @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </div>
                </li>
              @endguest
            </ul>
            <!-- END Right Side Of Navbar -->
          </div>
        </div>
      </nav>
      <main class="py-4">
        @yield('content')
      </main>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
  </body>
</html>