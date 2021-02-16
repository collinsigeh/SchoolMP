<!DOCTYPE html> 
<html> 

<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title> 
		Submission success
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
        <div class="text-center" style="padding: 80px 0 10px 0;">
            @include('partials._messages')
            <div style="padding-top: 25px;"><a href="{{ route('newdata.create_staff', $school_id) }}" class="btn btn-outline-primary">View staff data form</a></div>
        </div>
    </div>
</body> 
</html>