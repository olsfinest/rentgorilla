<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="@yield('description', '')">
    <meta name="keywords" content="@yield('keywords', '')">
    <meta name="token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RentGorilla.ca | @yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">
      <link rel="stylesheet" type="text/css" href="/css/typography.css">
      <link rel="stylesheet" type="text/css" href="/css/jquery-ui.theme.css">
      <link rel="stylesheet" type="text/css" href="/css/style.css">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <![endif]-->
      @yield('header')
  </head>
  <body>
        @if(Session::has('flash_message'))
            <div id="flash_message" style="position: fixed; top:50px; left:50px" class="alert alert-info">{{ Session::get('flash_message') }}</div>
        @endif
        @yield('content')
      <footer>
          <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
          <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
          <!--jQuery UI-->
          <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
          <script src="/js/auth.js"></script>
          <script language="JavaScript">

            $('#flash_message').fadeOut(5000);
          </script>
          @yield('footer')
      </footer>
  </body>
</html>