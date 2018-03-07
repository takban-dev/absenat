@extends('layouts.app')

@section('title')
داشبورد
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="fa fa-users" aria-hidden="true"></i>
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
            <i class="fa fa-building-o" aria-hidden="true"></i>
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
                    <i class="fa fa-user" aria-hidden="true"></i>
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
                    @if($group_code == 1)
                    <li>
                        <a href="{{url('admin/unit-new')}}">
                           <i class="fa fa-plus" aria-hidden="true"></i>
                            ساخت کارگاه جدید
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/user-new')}}">
                           <i class="fa fa-plus" aria-hidden="true"></i>
                            ساخت کاربر جدید
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/employee-new')}}">
                           <i class="fa fa-plus" aria-hidden="true"></i>
                            ساخت شاغل جدید
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{url('unit-new')}}">
                           <i class="fa fa-plus" aria-hidden="true"></i>
                            ساخت کارگاه جدید
                        </a>
                    </li>
                    <li>
                        <a href="{{url('employee-new')}}">
                           <i class="fa fa-plus" aria-hidden="true"></i>
                            ساخت شاغل جدید
                        </a>
                    </li>
                    @endif
                </ul>   
            </div>
        </div>
    </div>
    @if($group_code == 1)
    <div class="col-lg-6 col-md-6">
        <div class="card rtl">
            <div class="card-content">
                @if (sizeof($reports) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">عنوان</th>
                            <th class="rtl text-center">اجرا</th>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->title }}</td>
                                    <td><a href="{{ url( 'admin/report/' . $report->id) }}"><i class="fa fa-file" aria-hidden="true"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span>هیچ فرم گزارش گیری وجود ندارد</span>
                @endif
            </div>
        </div>
    </div>
    @endif
    </div>
</div>
@endsection