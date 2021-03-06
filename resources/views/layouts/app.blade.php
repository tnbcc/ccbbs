<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE-edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>@yield('title','Ccbbs')</title>

     <!-- Styles -->
     <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     @yield('styles')
</head>

<body>
       <div id="app" class="{{ route_class() }}-page">
          @include('layouts.header')
          <div class="container">

             @include('layouts.message')
             @yield('content')

          </div>
            @include('layouts.footer')
      </div>

      <!-- Script -->
      <script src="{{ asset('js/app.js') }}"></script>
      @yield('scripts')
</body>
</html>
