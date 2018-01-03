@extends('layouts.app')

@section('title')
کاربران
@endsection

@section('back')
<li>
    <a href="{{url('dashboard')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">کاربران</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                @if (sizeof($users) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=first_name,last_name'}}">نام و نام خانوادگی</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=phone'}}">شماره تماس</a>
                            </th>
                            <th class="rtl text-center">مشاهده اطلاعات</th>
                            <th class="rtl text-center">حذف</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                    <td>{{ $user->cellphone }}</td>
                                    <td><a href="{{ url( 'admin/user/' . $user->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'admin/user-remove/' . $user->id) }}"><i class="material-icons">delete</i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <span>هیچ کاربری ثبت نشده است</span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="text-align: center;">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="{{($currentPage > 1)?url('admin/users/0/' . $pageSize. $sort):'#'}}">صفحه اول</a></li>
                <li class="page-item"><a class="page-link" href="{{($currentPage > 0)?url('admin/users/' . ($currentPage-1) . '/' . $pageSize. $sort):'#'}}">صفحه اول</a></li>
                <li class="page-item active"><a class="page-link" href="#">{{$currentPage+1}}/{{$pageCount}}</a></li>
                <li class="page-item"><a class="page-link" href="{{($currentPage+1 < $pageCount)? url('admin/users/' . ($currentPage+1) . '/' . $pageSize. $sort):'#'}}">صفحه بعد</a></li>
                <li class="page-item"><a class="page-link" href="{{($currentPage+2 < $pageCount)? url('admin/users/' . ($pageCount-1) . '/' . $pageSize. $sort):'#'}}">صفحه آخر</a></li>
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('admin/user-new')}}">
            <button type="button" class="btn btn-primary pull-right">کاربر جدید</button>
        </a>
    </div>
</div>
@endsection