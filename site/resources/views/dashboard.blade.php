@extends('layouts.app')

@section('title')
داشبورد
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">people</i>
            </div>
            <div class="card-content">
                <p class="category">شاغلین</p>
                <h3 class="title">{{$employeeCount}}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">business_center</i>
            </div>
            <div class="card-content">
                <p class="category">واحد ها</p>
                <h3 class="title">{{$unitCount}}</h3>
            </div>
        </div>
    </div>
    @if($group_code == 1)
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="blue">
                    <i class="material-icons">person</i>
                </div>
                <div class="card-content">
                    <p class="category">کاربران</p>
                    <h3 class="title">{{$userCount}}</h3>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="row">

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