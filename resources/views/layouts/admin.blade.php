<html>
<head>
    <script src="/js/prefixfree.min.js"></script>
    <link rel="icon" href="/img/favicon.png">
    <meta name="viewport" content="initial-scale=1">
    <meta name="token" content="{{ csrf_token() }}">
    <meta name="loggedin" content="{{ Auth::check() ? '1' : '0' }}">
    <title>RentGorilla || Move on up.</title>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/js/charts/c3.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="/css/typography.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.theme.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/integrate.css">
    @yield('head')
</head>
<body>
@include('partials.header-logo-login-signup')
<!-- new stylesheet for logged-in users -->
<link rel="stylesheet" href="/css/admin.css">
<!-- navigation for logged-in users -->
@include('partials.admin-nav')
<section class="main">
@yield('content')
</section>
@include('partials.notifications')
<footer>
    <!--jQuery-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!--jQuery UI-->
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <!--Maps-->
    <section class="content"></section>
    <script src="/js/auth.js"></script>
    <script src="/js/notifications.js"></script>
    <script language="JavaScript" type="text/javascript">

        jQuery('.fa-question-circle').tooltip({
            position: { my: "bottom", at: "left center" }
        });

        setInterval(function(){
            $('.eyes').toggleClass('blink');
            setTimeout(function(){
                $('.eyes').toggleClass('blink')
            }, 200);
        }, 5000);
    </script>
    @yield('footer')
</footer>
</body>
</html>
