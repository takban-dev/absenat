<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name', 'no title')}}:@yield('title')</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet"/>

    <!-- <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Lateef" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{ asset('js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.autocomplete.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/chartist.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('js/material-dashboard.js') }}"></script>
    <script src="{{ asset('js/reports.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href='http://awebfont.ir/css?id=1920' rel='stylesheet' type='text/css'>
    <script>
        body {
            font-family: '0 Roya', tahoma, Arial;
        }
    </script>
</head>
<body>
<div class="wrapper">
    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">سازمان مدیریت کار و خدمات اشتغال منطقه آزاد انزلی</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        @yield('back')
                        <li>
                            <a href="{{url('profile')}}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('logout')}}">
                               <i class="fa fa-lock" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
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
                    <a href="http://www.takbanco.ir">تکبان رایانه کاسپین</a>&copy; طراحی توسط
                </p>
            </div>
        </footer>
    </div>
    <div class="sidebar" data-color="purple" data-image="{{ asset('img/sidebar-1.jpg') }}">
        <div class="logo">
            <img src="{{ asset('img/logo-small.png') }}"/>
        </div>

        <div class="sidebar-wrapper">
            <ul class="nav">
                @if(Request::url() == url('dashboard'))
                    <li class="active">
                @else
                    <li>
                @endif
                    <a href="{{url('dashboard')}}">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                        <p>داشبورد</p>
                    </a>
                </li>
                @if ($group_code)
                    @if(Request::url() == url('admin/users'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/users')}}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <p>کاربران</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/units'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/units')}}">
                        <i class="fa fa-building" aria-hidden="true"></i>
                            <p>کارگاه ها</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/employees'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/employees')}}">
                          <i class="fa fa-id-card" aria-hidden="true"></i>
                            <p>شاغلین</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/reports'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/reports')}}">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            <p>آمار ها و گزارشات</p>
                        </a>
                    </li>
                    @if(Request::url() == url('admin/backup'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('admin/backup')}}">
                        <i class="fa fa-hdd-o" aria-hidden="true"></i>
                          <p>پشتیبان گیری</p>
                        </a>
                    </li>
                @else
                    @if(Request::url() == url('units'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                        <a href="{{url('units')}}">
                          <i class="fa fa-building" aria-hidden="true"></i>
                          <p>کارگاه ها</p>
                        </a>
                    </li>
                    @if(Request::url() == url('employees'))
                        <li class="active">
                    @else
                        <li>
                    @endif
                      <a href="{{url('employees')}}">
                        <i class="fa fa-id-card" aria-hidden="true"></i>
                          <p>شاغلین</p>
                      </a>
                    </li>
                @endif
                
            </ul>
        </div>
    </div>
</div>
</body>
@yield('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
</html>
