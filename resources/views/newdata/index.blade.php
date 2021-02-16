<!DOCTYPE html> 
<html> 

<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title> 
		New Data
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @yield('stylesheets')
</head>
<body>
    <div class="container">
        <div style="padding: 40px 0 10px 0;">
            @include('partials._messages')
        </div>
        <div class="resource-details text-center" style="margin: 20px 0;">
            <p>Contact the system admin:</p>
            <ul>
                <li>Call: <b><a href="tel:+2347032869266">+234 (0) 703 286 9266</a></b></li>
                <li>Send email to: <b><a href="mailto:igehac@gmail.com"></a>igehac@gmail.com</b></li>
            </ul>
        </div>
    </div>
</body> 
</html>