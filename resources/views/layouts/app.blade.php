<!DOCTYPE html>
<html lang="en">
	<head>
		<script src="/js/prefixfree.min.js"></script>
		<link rel="icon" href="/img/favicon.png">
		<meta name="viewport" content="initial-scale=1">
		<meta name="token" content="{{ csrf_token() }}">
        <meta name="loggedin" content="{{ Auth::check() ? '1' : '0' }}">
		<title>@yield('title', 'RentGorilla | Find & Rent Your Next Home')</title>
        <meta name="description" content="Discover rental listings from all over Nova Scotia. Add your rental property for free.">
        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/css/select2.min.css" rel="stylesheet" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="/css/typography.css">
		<link rel="stylesheet" type="text/css" href="/css/jquery-ui.theme.css">
		<link rel="stylesheet" type="text/css" href="/css/style.css?v=1">
        @yield('head')
	</head>
	<body>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-67070500-1', 'auto');
          ga('send', 'pageview');

        </script>
        @yield('content')
        @include('partials.notifications')
        <footer>
            @include('partials.footer')
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <!--jQuery UI-->
            <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
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
                $(window).load(function(){
                    $('.view_switcher span.ui-icon.ui-icon-arrowthick-1-s').addClass('ui-icon-white');
                });
                $(window).scroll(function() {    
                    var scroll = $(window).scrollTop();

                    if (scroll >= 95) {
                        $("body").addClass("fixed");
                    }
                    if (scroll <= 95) {
                        $("body").removeClass("fixed");
                    }
                });
            </script>
        </footer>
	</body>
</html>