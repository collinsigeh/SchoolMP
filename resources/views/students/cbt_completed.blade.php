<!DOCTYPE html> 
<html> 

<head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title> 
		CBT - Completed
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
            <h3>Thanks for taking our CBT.</h3>
            <div style="padding-top: 25px;"><a href="{{ route('students.term', $attempt->enrolment_id) }}" class="btn btn-outline-primary">Back to dashboard!</a></div>
        </div>
    </div>
</body> 
</html>