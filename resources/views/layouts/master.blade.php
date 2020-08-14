<!DOCTYPE HTML>
<html lang="en">
   <head>
        <meta charset="utf-8" >
        <title>Laravel Project - @yield('title')</title>

   </head>
   <body>

        @section('header')
           MASTER HEADER
        @show

        <div class="container">
           @yield('content')
        </div>

        @section('footer')
            MASTER FOOTER
        @show

   </body>
</html>
