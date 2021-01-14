<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    
    <title>@yield('title')</title>
</head>

<body>
    <div class="container">
        @yield('content')
    </div>

    @yield('script')
</body>
</html>