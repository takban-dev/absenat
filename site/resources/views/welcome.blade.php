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
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <a href="login"><button type="submit" class="btn btn-primary pull-right">ورود</button></a>
                    <a href="register"><button type="submit" class="btn btn-primary pull-left">ثبت نام</button></a>
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
