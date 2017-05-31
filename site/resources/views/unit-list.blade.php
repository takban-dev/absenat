@extends('layouts.app')

@section('title')
کارگاه ها
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
                <h4 class="title">کارگاه ها</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                @if (sizeof($units) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">عنوان کارگاه</th>
                            <th class="rtl text-center">مدیریت</th>
                            <th class="rtl text-center">شماره تماس</th>
                            <th class="rtl text-center">مشاهده کارگاه</th>
                            <th class="rtl text-center">حذف</th>
                            </thead>
                            <tbody>
                            @foreach ($units as $unit)
                                <tr>
                                    <td>{{ $unit->title }}</td>
                                    <td>{{ $unit->manager_title }}</td>
                                    <td>{{ $unit->phone }}</td>
                                    <td><a href="{{ url( 'admin/unit/' . $unit->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'admin/unit-remove/' . $unit->id) }}"><i class="material-icons">delete</i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span>هیچ کارگاهی ثبت نشده است</span>
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
                        <li class="page-item"><a class="page-link" href="{{url('admin/units/' . ($page-1) . '/' . $pageSize)}}">{{$page}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('admin/unit-new')}}">
            <button type="button" class="btn btn-primary pull-right">کارگاه جدید</button>
        </a>
    </div>
</div>
@endsection