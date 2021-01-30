<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
	<link href="{{ url('css/fonts.css') }}" rel="stylesheet">
	<link rel="icon" type="image/png" href="{{ URL::to('/') }}/favicon.ico"/>
    
	<title>QRnow - аутентификация</title>
</head>
<body>
    <!-- навбар -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="nav_link"><img style="max-width: 3em; max-height: 3em;" src="{{ URL::to('/') }}/images/favicon.png" alt=""></a>
        <a class="navbar-brand">QRnow</a>
    </nav>

    <!-- форма аутентификации -->
    <div style="margin-top: 10px" class="container">
        @yield('content')
    </div>
</body>
</html>