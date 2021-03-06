@extends('layouts.print')

@section('title')
لیست شاغلین
@endsection
@section('content')
@if($complete)
    @foreach($employees as $employee)
        <div class="panel panel-default rtl">
            <div class="panel-heading">{{$employee->first_name}} {{$employee->last_name}}</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        نام: {{$employee->first_name}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        نام خانوادگی: {{$employee->last_name}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        کد ملی: {{$employee->id_number}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        جنسیت: {{$gender[$employee->gender]}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        نام پدر: {{$employee->father_name}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        محل تولد: {{$employee->birth_place}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        تاریخ تولد: {{preg_replace('/-/', '/', $employee->birth_date)}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        محل سکونت: {{$habitate[$employee->habitate]}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        سال های سکونت: {{$employee->habitate_years}} سال
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 pull-right">
                        آدرس دقیق: {{$employee->address}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        مدرک: {{$degree[$employee->degree]}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        رشته: {{$field[$employee->field]}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        گارکاه: {{$employee->unitTitle}}
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        عنوان شغلی: {{$job[$employee->job]}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        سابقه کار: {{$employee->experience}} ماه
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                        وضعیت تاهل: {{$marrige[$employee->marrige]}} 
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 pull-right">
                        تعداد افراد تحت تکفل: {{$employee->dependents}} نفر
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <table class="table table-hover">
        <thead>
            <th class="rtl text-center">نام و نام خانوادگی</th>
            <th class="rtl text-center">محل سکونت</th>
            <th class="rtl text-center">مدرک و رشته تحصیلی</th>
            <th class="rtl text-center">کارگاه</th>
            <th class="rtl text-center">عنوان شغلی</th>
            </thead>
            <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td class="rtl text-center">{{$employee->first_name . ' ' . $employee->last_name}}</td>
                    <td class="rtl text-center">{{$habitate[$employee->habitate]}}</td>
                    <td class="rtl text-center">{{$field[$employee->field] . ' - ' . $degree[$employee->degree]}}</td>
                    <td class="rtl text-center">{{$employee->unitTitle}}</td>
                    <td class="rtl text-center">{{$job[$employee->job]}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection