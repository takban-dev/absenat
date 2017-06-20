@extends('layouts.app')

@section('title')
آمار ها
@endsection

@section('back')
<li>
    <a href="{{url('admin/reports')}}">
        <i class="material-icons">keyboard_return</i>
    </a>
</li>
@endsection

@section('content')
<div class="card rtl">
    <div class="card-header" data-background-color="purple">
        <h4 class="title">تعداد شاغلین به تفکیک جنسیت</h4>
    </div>
    <div class="card-content">
        <div class="row">
            <form action="{{url('admin/reports/genders-list')}}" method="get">
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
                <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                    <div class="form-group label-floating rtl col-lg-12 col-md-12">
                        <label class="control-label">از ردیف</label>
                        <input type="text" value="{{isset($oldInputs)? $oldInputs['offset']: ''}}" name="offset" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                    <div class="form-group label-floating rtl col-lg-12 col-md-12">
                        <label class="control-label">به تعداد</label>
                        <input type="text" value="{{isset($oldInputs)? $oldInputs['limit']: ''}}" name="limit" class="form-control">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-lg-4">
                    <button type="submit" class="btn btn-primary pull-right" style="margin-top: 3rem;">مشاهده لیست</button>
                </div>
            </form>
        </div>
@if(isset($results))
        <table class="table table-hover text-center">
            <thead>
                @foreach($headers as $key => $value)
                    <th class="rtl text-center">
                        <a href="{{$query . 'sort=' . $key}}">{{$value}}</a>
                    </th>
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
@endsection