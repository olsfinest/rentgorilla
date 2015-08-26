<!DOCTYPE html>
<html lang="en">
	<head>
		<script src="/js/prefixfree.min.js"></script>
		<link rel="icon" href="/img/favicon.png">
		<meta name="viewport" content="initial-scale=1">
		<meta name="token" content="{{ csrf_token() }}">
        <meta name="loggedin" content="{{ Auth::check() ? '1' : '0' }}">
		<title>@yield('title', 'RentGorilla || Move on up.')</title>
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/css/select2.min.css" rel="stylesheet" />
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="/css/typography.css">
		<link rel="stylesheet" type="text/css" href="/css/jquery-ui.theme.css">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
        @yield('head')
	</head>
	<body>
        @yield('content')
        @include('partials.notifications')
        <footer>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <!--jQuery UI-->
            <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
            <script src="/js/auth.js"></script>
            <script src="/js/notifications.js"></script>
            @yield('footer')
            <script language="JavaScript" type="text/javascript">
                setInterval(function(){
                    $('.eyes').toggleClass('blink');
                    setTimeout(function(){
                        $('.eyes').toggleClass('blink')
                    }, 200);
                }, 5000);
            </script>
        </footer>
	</body>
</html>