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
    <div class="col-lg-6 col-md-6">
        <div class="card rtl">
            <div class="card-content">
                <ul class="nav">
                    <li>
                        <a href="{{url('admin/unit-new')}}">
                            <i class="material-icons">add_box</i>
                            ساخت کارگاه جدید
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/user-new')}}">
                            <i class="material-icons">add_box</i>
                            ساخت کاربر جدید
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/employee-new')}}">
                            <i class="material-icons">add_box</i>
                            ساخت شاغل جدید
                        </a>
                    </li>
                </ul>   
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card rtl">
            <div class="card-content">
                <ul class="nav">
                    <li>
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            گزارش یک
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            گزارش دو
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            گزارش سه
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            گزارش چهار
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            گزارش پنج
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/reports')}}">
                            <i class="material-icons">show_chart</i>
                            گزارش شش
                        </a>
                    </li>
                </ul>   
            </div>
        </div>
    </div>
</div>
@endsection