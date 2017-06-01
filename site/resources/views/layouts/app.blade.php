<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ابسنات:@yield('title')</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet"/>

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lateef" rel="stylesheet">
    
    <script src="{{ asset('js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.autocomplete.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartist.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('js/material-dashboard.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>

</head>
<body>
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="{{ asset('img/sidebar-1.jpg') }}">
        <div class="logo">
            <img src="{{ asset('img/logo-small.png') }}"/>
        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="active">
                    <a href="{{url('dashboard')}}">
                        <i class="material-icons">dashboard</i>
                        <p>داشبورد</p>
                    </a>
                </li>
                @if ($group_code)
                    <li>
                        <a href="{{url('admin/users')}}">
                            <i class="material-icons">people</i>
                            <p>کاربران</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/units')}}">
                            <i class="material-icons">library_books</i>
                            <p>کارگاه ها</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/employees')}}">
                            <i class="material-icons">people_outline</i>
                            <p>شاغلین</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            <p>آمار ها</p>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{url('units')}}">
                            <i class="material-icons">library_books</i>
                            <p>کارگاه ها</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('employees')}}">
                            <i class="material-icons">people_outline</i>
                            <p>شاغلین</p>
                        </a>
                    </li>
                @endif
                
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            @yield('header')
        </nav>

        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright">
                    <script>document.write(new Date().getFullYear())</script>
                    <a href="http://www.prechaos.ir">Reza</a>&copy; طراحی توسط
                </p>
            </div>
        </footer>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function () {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>
</html>
