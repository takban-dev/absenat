@extends('layouts.app')

@section('title')
شاغلین
@endsection


@section('back')
<li>
    <a href="{{url('dashboard')}}">
       <i class="fa fa-level-up" aria-hidden="true"></i>
    </a>
</li>
@endsection

@section('content')
<script>
  function remove (employeeId, employeeName){
    var result = confirm("آیا واقعا مایل به حذف اظلاعات شاغل " + employeeName + " هستید؟");
    if (result) {
        window.location = '{{ url( 'admin/employee-remove/') }}/' + employeeId
    }
  }
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">شاغلین</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                <div class="row" style="margin-bottom: 25px;">
                    <form action="{{url('admin/employees/')}}" method="get">
                    <div class="col-md-4 pull-right">
                        <div class="form-group label-floating">
                            <label class="control-label">نام</label>
                            <input type="text" name="first_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 pull-right">
                        <div class="form-group label-floating">
                            <label class="control-label">نام خانوادگی</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary text-center">جستجو</button>
                    </div>
                    </form>
                </div>
                @if (sizeof($employees) > 0)
                    <table class="table table-hover">
                        <thead>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=first_name,last_name'}}">نام و نام خانوادگی</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=habitate'}}">محل سکونت</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=degree,field'}}">مدرک و رشته تحصیلی</a>
                            </th>
                            <th class="rtl text-center">
                                <a href="{{Request::url() . '?sort=unit_id'}}">کارگاه</a>
                            </th>
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
                                    <td><a href="{{ url( 'admin/employee/' . $employee->id) }}"><i class="fa fa-file" aria-hidden="true"></i></a></td>
                                    <!-- <td><a href="{{ url( 'admin/employee-remove/' . $employee->id) }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td> -->
                                    <td><a onclick="remove({{$employee->id}}, '{{$employee->first_name . ' ' . $employee->last_name}}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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
                <li class="page-item"><a class="page-link" href="{{($currentPage > 1)?url('admin/employees/0/' . $pageSize. $sort):'#'}}">صفحه اول</a></li>
                <li class="page-item"><a class="page-link" href="{{($currentPage > 0)?url('admin/employees/' . ($currentPage-1) . '/' . $pageSize. $sort):'#'}}">صفحه اول</a></li>
                <li class="page-item active"><a class="page-link" href="#">{{$currentPage+1}}/{{$pageCount}}</a></li>
                <li class="page-item"><a class="page-link" href="{{($currentPage+1 < $pageCount)? url('admin/employees/' . ($currentPage+1) . '/' . $pageSize. $sort):'#'}}">صفحه بعد</a></li>
                <li class="page-item"><a class="page-link" href="{{($currentPage+2 < $pageCount)? url('admin/employees/' . ($pageCount-1) . '/' . $pageSize. $sort):'#'}}">صفحه آخر</a></li>
            </ul>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="{{url('admin/employee-new')}}">
            <button type="button" class="btn btn-primary pull-right">شاغل جدید</button>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card rtl">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">ارائه پرینت از لیست شاغلین</h4>
            </div>
            <div class="card-content table-responsive" style="text-align: center;">
                <form action="{{url('admin/employee-list-print/')}}" method="get" target="_blank">
                    <input name="pageSize" type="hidden" value="{{$pageSize}}">
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        <div class="col-md-4 col-sm-12">
                            <select class="form-control" name="startPage" style="padding-top: 0px">
                                @for ($i=0; $i<$pageCount; $i++)
                                    <option value="{{$i}}">{{$i+1}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-8 col-sm-12 text-center" style="margin-top: 30px;">
                            <span>از صفحه</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        <div class="col-md-4 col-sm-12">
                            <select class="form-control" name="endPage" style="padding-top: 0px">
                                @for ($i=0; $i<$pageCount; $i++)
                                    <option value="{{$i}}">{{$i+1}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-8 col-sm-12 text-center" style="margin-top: 30px;">
                            <span>تا صفحه</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right nrtl">
                        <div class="checkbox" style="margin-top: 4rem;">
                            نمایش اطلاعات کامل
                            <label>
                                <input type="checkbox" name="complete">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right" style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary text-center">ارائه گزارش</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection