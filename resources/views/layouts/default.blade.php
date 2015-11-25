<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PageLab</title>

    <!-- Bootstrap -->
    <link href="{{ asset('/assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        
        body{
            width: 100vw;
            height: 100vh;
            background: white;
        }

        .container{
            display: flex;
            height: 100vh;
            align-items: center;  /* align in cross axis */
        }

        .login-view{
            flex: 1 1 auto;
        }
        
    </style>
</head>
<body>

<main class="container">
    @yield('content')
</main><!-- .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('/assets/js/vendor/jquery.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('/assets/js/vendor/bootstrap.js')}}"></script>

@yield('js')

</body>
</html>
