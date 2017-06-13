@extends('layouts.app')

@section('title')
آمار ها
@endsection
@section('content')
<div class="card rtl">
    <div class="card-header" data-background-color="purple">
        <h4 class="title">تعداد شاغلین به تفکیک جنسیت</h4>
    </div>
    <div class="card-content">
        <div class="row">
            <form action="{{url('admin/reports/genders-list/1/10')}}" method="post">
                {{ csrf_field() }}
                <div class="col-md-6 col-sm-12 pull-right">
                    <div class="col-md-8 col-sm-8">
                        <div class="form-group rtl col-lg-12 col-md-12">
                            <div class="form-group" style="margin-top: 0px">
                                <select class="form-control" name="gender" style="padding-top: 0px">
                                    <option value="1">هردو</option>
                                    <option value="2">مرد</option>
                                    <option value="3">زن</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                        <span>مشاهده جنسیت</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 pull-right">
                    <div class="col-md-8 col-sm-8">
                        <div class="form-group rtl col-lg-12 col-md-12">
                            <div class="form-group" style="margin-top: 0px">
                                <select class="form-control" name="gender" style="padding-top: 0px">
                                    <option value="1">هردو</option>
                                    <option value="2">مرد</option>
                                    <option value="3">زن</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                        <span>از ردیف</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 pull-right">
                    
                    <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                        <span>به تعداد</span>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-lg-4">
                    <button type="submit" class="btn btn-primary pull-right" style="margin-top: 3rem;">مشاهده لیست</button>
                </div>
            </form>
        </div>
@if(isset($results))
        <table class="table table-hover">
            <thead>
                @foreach($headers as $header)
                    <th class="rtl">{{$header}}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach($results as $row)
                    <tr>
                        @foreach($row as $item)
                            <td>{{$item}}</td>
                        @endforeach
                    </tr>    
                @endforeach
            </tbody>
        </table>
@endif
    </div>
</div>
@if(isset($results))
<div class="row">
    <div class="col-md-12" style="text-align: center;">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @foreach ($pagination as $page)
                    @if ($page == '#')
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{url('admin/employees/' . ($page-1) . '/' . $pageSize . '/' . $gender)}}">{{$page}}</a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
@endif
@endsection