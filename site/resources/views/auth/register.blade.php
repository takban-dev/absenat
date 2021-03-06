<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet"/>

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lateef" rel="stylesheet">
</head>

<body>

<div class="wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-4 col-md-4">
                    <img src="{{ asset('img/logo-big.png') }}" class="img-responsive"/>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="alert alert-danger">
                        <button type="button" aria-hidden="true" class="close">×</button>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="card">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper rtl">
                                <ul class="nav nav-tabs">
                                    <li class="pull-right">
                                        <a href="{{ route('login') }}">ورود</a>
                                    </li>
                                    <li class="active pull-right">
                                        <a href="#">ثبت نام</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">نام کاربری</label>
                                            <input type="text" class="form-control" id="name" type="name" name="name" value="{{ old('name') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">آدرس ایمیل</label>
                                            <input type="email" id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">کلمه عبور</label>
                                            <input type="password" class="form-control" id="password" type="password" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">تکرار کلمه عبور</label>
                                            <input type="password" id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">نام</label>
                                            <input type="text" class="form-control" id="first_name" type="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">نام خانوادگی</label>
                                            <input type="text" id="last_name" type="last_name" name="last_name" value="{{ old('last_name') }}" required class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">شماره تلفن ثابت</label>
                                            <input type="text" class="form-control" id="phone" type="phone" name="phone" value="{{ old('phone') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                            <label class="control-label">تلفن همراه</label>
                                            <input type="text" id="cellphone" type="cellphone" name="cellphone" value="{{ old('cellphone') }}" required class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary pull-right">ورود</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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

</body>

<script src="{{ asset('js/jquery-3.1.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/chartist.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-notify.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script src="{{ asset('js/material-dashboard.js') }}"></script>
<script src="{{ asset('js/demo.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>

</html>
