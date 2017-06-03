@extends('layouts.app')

@section('title')
شاغلین
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">شاغلین</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                @if (sizeof($employees) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">نام و نام خانوادگی</th>
                            <th class="rtl text-center">محل سکونت</th>
                            <th class="rtl text-center">مدرک و رشته تحصیلی</th>
                            <th class="rtl text-center">کارگاه</th>
                            <th class="rtl text-center">مشاهده اطلاعات شاغل</th>
                            <th class="rtl text-center">حذف</th>
                            </thead>
                            <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{$employee->first_name . ' ' . $employee->last_name}}</td>
                                    <td>{{$employee->habitate}}</td>
                                    <td>{{$employee->field . ' - ' . $employee->degree}}</td>
                                    <td>{{$employee->unit}}</td>
                                    <td><a href="{{ url( 'employee/' . $employee->id) }}"><i class="material-icons">assignment_ind</i></a></td>
                                    <td><a href="{{ url( 'employee-remove/' . $employee->id) }}"><i class="material-icons">delete</i></a></td>
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
                        <li class="page-item"><a class="page-link" href="{{url('employees/' . ($page-1) . '/' . $pageSize)}}">{{$page}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('employee-new')}}">
            <button type="button" class="btn btn-primary pull-right">شاغل جدید</button>
        </a>
    </div>
</div>
@endsection