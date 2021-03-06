<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Logo -->
    <link href = "/img/logo-new.png" rel="icon">

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/brands.css" integrity="sha384-1KLgFVb/gHrlDGLFPgMbeedi6tQBLcWvyNUN+YKXbD7ZFbjX6BLpMDf0PJ32XJfX" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/fontawesome.css" integrity="sha384-jLuaxTTBR42U2qJ/pm4JRouHkEDHkVqH0T1nyQXn1mZ7Snycpf6Rl25VBNthU4z0" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Lobster|Oswald" rel="stylesheet">
    @yield('style')
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top bg-white">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a href="{{ url('/') }}">
                        <img class="logo-iit" src="../../img/iit-hor.png"/>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <!-- Project Category Navigation Bar -->
                    <ul class="unhide-less-768 nav navbar-nav montserrat" role="tablist">
                        <li role="presentation" class="active">
                            <a onclick="$('#app-navbar-collapse').attr('class', 'navbar-collapse collapse');" href="#website" aria-controls="website" role="tab" data-toggle="tab">
                                <i class="fa fa-html5" aria-hidden="true"></i>&nbsp; Website
                            </a>
                        </li>
                        <li role="presentation">
                            <a onclick="$('#app-navbar-collapse').attr('class', 'navbar-collapse collapse');" href="#mobile" aria-controls="mobile" role="tab" data-toggle="tab">
                                <i class="fa fa-mobile" aria-hidden="true"></i>&nbsp; Mobile
                            </a>
                        </li>
                        <li role="presentation">
                            <a onclick="$('#app-navbar-collapse').attr('class', 'navbar-collapse collapse');" href="#desktop" aria-controls="desktop" role="tab" data-toggle="tab">
                                <i class="fa fa-desktop" aria-hidden="true"></i>&nbsp; Desktop
                            </a>
                        </li>
                        <li role="presentation">
                            <a onclick="$('#app-navbar-collapse').attr('class', 'navbar-collapse collapse');" href="#others" aria-controls="others" role="tab" data-toggle="tab">
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>&nbsp; Others
                            </a>
                        </li>
                    </ul>

                    <!-- Left Side Of Navbar -->
                    <ul class="hide-less-768 nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::user()->role == 'admin')
                        <li>
                            <a href="/admin">
                                <i class="fa fa-cog" aria-hidden="true"></i>&nbsp; Manage Users
                            </a>
                        </li>
                        @endif
                        @can('create', App\Project::class)
                        <li>
                            <a href="/project/create">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Post Project
                            </a>
                        </li>
                        @endcan
                        <li class="hide-less-768">
                            <a href="/home"><i class="fa fa-file" aria-hidden="true"></i>&nbsp; Projects</a>
                        </li>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="auth/google">Sign In</a></li>
                            <!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
                        @else
                            <li>
                                <a href="{{ url('/logout') }}" style="display:inline-block"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> Logout&nbsp;
                                </a>
                                <a href="{{url('/user/'.Auth::user()->id)}}" style="display:inline-block">
                                <i class="fa fa-user" aria-hidden="true"></i> My Profile
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    </ul>
                    
                </div>
            </div>
        </nav>
        <div class="heading">
            <hr class="divider">
            <h1 class="white text-center">@yield('title-page')</h1>
        </div>

        @yield('message')
        @yield('content')
    </div>
    <footer class="bg-black-grey white">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h6>Cornelius Yan M.</h6>
                    <h6><i class="fa fa-phone fa-lg amber" aria-hidden="true"></i>&nbsp; +62 896 5410 8308</h6>
                </div>
                <div class="col-md-3">
                    <h6>About Us</h6>
                    <h6><i class="fa fa-home fa-lg amber" aria-hidden="true"></i>
                        <a href="https://inkubatorit.com/" class="white">&nbsp; Inkubator IT</a>
                    </h6>
                </div>
                <div class="col-md-3">
                    <h6>Follow Us</h6>
                    <h6><i class="fa fa-instagram fa-lg amber" aria-hidden="true"></i>
                        <a href="https://www.instagram.com/inkubatorit/?hl=en" class="white">&nbsp; @inkubatorit</a>
                    </h6>
                </div>
                <div class="col-md-3 text-center">
                    <img src="../../img/logo-hmif.jpg" style="width: 70px" />
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/js/motask.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>
