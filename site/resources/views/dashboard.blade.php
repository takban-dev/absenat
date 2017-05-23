@extends('layouts.app')

@section('title')
داشبورد
@endsection
@section('side-bar')
<ul class="nav">
    <li class="active">
        <a href="dashboard">
            <i class="material-icons">dashboard</i>
            <p>داشبورد</p>
        </a>
    </li>
    @if ($group_code)
        <li>
            <a href="admin/users">
                <i class="material-icons">people</i>
                <p>کاربران</p>
            </a>
        </li>
        <li>
            <a href="admin/units">
                <i class="material-icons">library_books</i>
                <p>کارگاه ها</p>
            </a>
        </li>
        <li>
            <a href="admin/employees">
                <i class="material-icons">people_outline</i>
                <p>شاغلین</p>
            </a>
        </li>
        <li>
            <a href="admin/reports">
                <i class="material-icons">show_chart</i>
                <p>آمار ها</p>
            </a>
        </li>
    @else
        <li>
            <a href="units">
                <i class="material-icons">library_books</i>
                <p>کارگاه ها</p>
            </a>
        </li>
        <li>
            <a href="employees">
                <i class="material-icons">people_outline</i>
                <p>شاغلین</p>
            </a>
        </li>
    @endif
    
</ul>
@endsection

@section('header')
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="#">سامانه مدیریت اشتغال سازمان منطقه آزاد انزلی</a>
</div>
<div class="collapse navbar-collapse">
<ul class="nav navbar-nav navbar-right">
<li>
<a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
<i class="material-icons">person</i>
<p class="hidden-lg hidden-md">Profile</p>
</a>
</li>
</ul>

<form class="navbar-form navbar-right" role="search">
<div class="form-group  is-empty">
<input type="text" class="form-control rtl" placeholder="جستجو">
<span class="material-input"></span>
</div>
<button type="submit" class="btn btn-white btn-round btn-just-icon">
<i class="material-icons">search</i><div class="ripple-container"></div>
</button>
</form>
</div>
</div>
@endsection

@section('content')
<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="orange">
<i class="material-icons">people</i>
</div>
<div class="card-content">
<p class="category">شاغلین</p>
<h3 class="title">1265</h3>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="green">
<i class="material-icons">business_center</i>
</div>
<div class="card-content">
<p class="category">واحد ها</p>
<h3 class="title">420</h3>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="red">
<i class="material-icons">vertical_align_bottom</i>
</div>
<div class="card-content">
<p class="category">درخواست ها</p>
<h3 class="title">45</h3>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header" data-background-color="blue">
<i class="material-icons">person</i>
</div>
<div class="card-content">
<p class="category">کاربران</p>
<h3 class="title">80</h3>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-6 col-lg-6 col-sm-12">
<div class="card">
<div class="card-header card-chart" data-background-color="red">
<div class="ct-chart" id="dailyRequestsChart"></div>
</div>
<div class="card-content">
<h4 class="title rtl">درخواست های روزانه</h4>
</div>
<div class="card-footer rtl">
<div class="stats">
    <i class="material-icons">access_time</i> 5 درخواست برای امروز
</div>
</div>
</div>
</div>

<div class="col-md-6 col-lg-6 col-sm-12">
<div class="card">
<div class="card-header card-chart" data-background-color="blue">
<div class="ct-chart" id="monthlySignsChart"></div>
</div>
<div class="card-content rtl">
<h4 class="title">ثبت نام ها</h4>
</div>
<div class="card-footer rtl">
<div class="stats">
    <i class="material-icons">access_time</i> 18 کاربر در ماه اخیر ثبت نام کردند
</div>
</div>

</div>
</div>

<div class="col-md-6 col-lg-6 col-sm-12">
<div class="card">
<div class="card-header card-chart" data-background-color="green">
<div class="ct-chart" id="monthlyUnitsChart"></div>
</div>
<div class="card-content rtl">
<h4 class="title">تعداد واحد ها</h4>
</div>
<div class="card-footer rtl">
<div class="stats">
    <i class="material-icons">access_time</i> 25 واحد در ماه اخیر ثبت شده‌اند
</div>
</div>

</div>
</div>

<div class="col-md-6 col-lg-6 col-sm-12">
<div class="card">
<div class="card-header card-chart" data-background-color="orange">
<div class="ct-chart" id="monthlyEmployeeChart"></div>
</div>
<div class="card-content rtl">
<h4 class="title">شاغلین</h4>
</div>
<div class="card-footer rtl">
<div class="stats">
    <i class="material-icons">access_time</i> 42 نفر در ماه اخیر اضافه شدند
</div>
</div>

</div>
</div>

</div>
@endsection