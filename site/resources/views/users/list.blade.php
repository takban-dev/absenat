@extends('layouts.app')

@section('title')
کاربران
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
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">شاغلین</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                @if (sizeof($users) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">نام و نام خانوادگی</th>
                            <th class="rtl text-center">شماره تماس</th>
                            <th class="rtl text-center">مشاهده اطلاعات</th>
                            <th class="rtl text-center">حذف</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                    <td>{{ $unit->cell_phone }}</td>
                                    <td><a href="{{ url( 'admin/user/' . $user->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'admin/user-remove/' . $user->id) }}"><i class="material-icons">delete</i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span>هیچ شاغلی ثبت نشده است</span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align: center;">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @foreach ($pagination as $page)
                    @if ($page == '#')
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{url('admin/users/' . ($page-1) . '/' . $pageSize)}}">{{$page}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('admin/user-new')}}">
            <button type="button" class="btn btn-primary pull-right">شاغل جدید</button>
        </a>
    </div>
</div>
@endsection