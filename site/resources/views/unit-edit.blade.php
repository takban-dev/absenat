@extends('layouts.app')

@section('title')
{{$oldInputs['title']}}
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
    </div>
</div>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger rtl">
        <ul>
        @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header rtl" data-background-color="purple">
                <h4 class="title">{{$oldInputs['title']}}</h4>
            </div>
            <div class="card-content">
                <form action="{{url('admin/unit/' . $oldInputs['id'])}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام واحد</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['title']: ''}}" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نوع فعالیت(محصول)</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['product']: ''}}" name="product" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام مدیر</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['manager_title']: ''}}" name="manager_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 pull-right">
                            <div class="form-group rtl col-lg-12 col-md-12">
                                <div class="form-group" style="margin-top: 0px">
                                    <select class="form-control" name="manager_gender" style="padding-top: 0px">
                                        @foreach ($genders->all() as $gender)
                                                <option value="{{$gender->id}}" {{isset($oldInputs)?($gender->id==$oldInputs['manager_gender']?'selected':''):''}}>{{$gender->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کد ملی</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['manager_id_number']: ''}}" name="manager_id_number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-lg-9 col-sm-12 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نشانی</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['address']: ''}}" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کد پستی</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['zip_code']: ''}}" name="zip_code" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">تلفن تماس ثابت</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['phone']: ''}}" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">تلفن همراه</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['cell_phone']: ''}}" name="cell_phone" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox pull-right">
                                مجوز فعالیت دارد
                                <label>
                                    <input type="checkbox" name="has_certificate" {{isset($oldInputs['has_certificate']) && $oldInputs['has_certificate'] == 1 ?'checked': ''}}>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">شماره مجوز</label>
                                <input type="text" value="{{isset($oldInputs['certificate_id']) && $oldInputs['certificate_id'] != '###' ? $oldInputs['certificate_id']: ''}}" name="certificate_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="col-md-3">
                                <select class="form-control" name="certificate_date_day" style="padding-top: 0px">
                                    @for ($i=1; $i<=30; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="certificate_date_month" style="padding-top: 0px">
                                    <option value="1">فروردین</option>
                                    <option value="2">اردیبهشت</option>
                                    <option value="3">خرداد</option>
                                    <option value="4">تیر</option>
                                    <option value="5">مرداد</option>
                                    <option value="6">شهریور</option>
                                    <option value="7">مهر</option>
                                    <option value="8">آبان</option>
                                    <option value="9">آذر</option>
                                    <option value="10">دی</option>
                                    <option value="11">بهمن</option>
                                    <option value="12">اسفند</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="certificate_date_year" style="padding-top: 0px">
                                    @for ($i=1390; $i<1400; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3" style="margin-top: 30px;">
                                <span>تاریخ صدور</span>
                            </div>
                        </div>
                        <div class="col-md-4 pull-right">
                            <div class="form-group rtl col-lg-12 col-md-12">
                                <div class="form-group" style="margin-top: 0px">
                                    <select class="form-control" name="certificate_type" style="padding-top: 0px">
                                        @foreach ($certificateTypes->all() as $certificateType)
                                                <option value="{{$certificateType->id}}" {{isset($oldInputs)?($certificateType->id==$oldInputs['certificate_type']?'selected':''):''}}>{{$certificateType->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox pull-right">
                                پروانه کسب دارد
                                <label>
                                    <input type="checkbox" name="has_licence" {{isset($oldInputs['has_licence']) && $oldInputs['has_licence'] == 1 ? 'checked': ''}}>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">شماره پروانه</label>
                                <input type="text" value="{{isset($oldInputs['licence_id']) && $oldInputs['certificate_id'] != '###'? $oldInputs['licence_id']: ''}}" name="licence_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <div class="col-md-3">
                                <select class="form-control" name="licence_date_day" style="padding-top: 0px">
                                    @for ($i=1; $i<=30; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="licence_date_month" style="padding-top: 0px">
                                    <option value="1">فروردین</option>
                                    <option value="2">اردیبهشت</option>
                                    <option value="3">خرداد</option>
                                    <option value="4">تیر</option>
                                    <option value="5">مرداد</option>
                                    <option value="6">شهریور</option>
                                    <option value="7">مهر</option>
                                    <option value="8">آبان</option>
                                    <option value="9">آذر</option>
                                    <option value="10">دی</option>
                                    <option value="11">بهمن</option>
                                    <option value="12">اسفند</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="licence_date_year" style="padding-top: 0px">
                                    @for ($i=1390; $i<1400; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3" style="margin-top: 30px;">
                                <span>تاریخ مجوز</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 pull-right">
                            <div class="form-group rtl col-lg-12 col-md-12">
                                <div class="form-group" style="margin-top: 0px">
                                    <select class="form-control" name="licence_source" style="padding-top: 0px">
                                        @foreach ($business_license_sources->all() as $business_license_source)
                                                <option value="{{$business_license_source->id}}" {{isset($oldInputs)?($business_license_source->id==$oldInputs['certificate_type']?'selected':''):''}}>{{$business_license_source->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">ثبت تغییرات</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection