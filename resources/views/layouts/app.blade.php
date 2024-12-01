<!doctype html>

<html
   lang="en"
   class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
   dir="ltr"
   data-theme="theme-default"
   data-assets-path="{{ asset('admin') }}/assets/"
   data-template="vertical-menu-template">
<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
   <meta name="description" content="News Aggregator" />
   <meta name="author" content="News Aggregator"/>

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>News Aggregator</title>

   <!-- Favicon -->
   <link rel="icon" type="image/x-icon" href="{{ asset('admin') }}/assets/img/favicon/ICON.png" />

   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com" />
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
   <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />

   @include('layouts.sections.styles')
</head>

<body>
   @include('layouts.sections.toasts')

   <!-- Layout wrapper -->
   <div class="container">
      <nav class="navbar align-items-center justify-content-center mb-2" id="layout-navbar">
         <img src="{{ asset('admin') }}/assets/img/favicon/ICON.png" width="50" height="50"/>
         <h3 style="margin: 0 0 0 15px">News Aggregator Website</h3>
      </nav>
      <div class="content-wrapper">
         <div class="container-xxl flex-grow-1">
            @yield('content')
         </div>
      </div>
   </div>

   @include('layouts.sections.scripts')
</body>
</html>
