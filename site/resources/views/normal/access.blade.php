@extends('layouts.app')

@section('title')
داشبورد
@endsection

@section('back')
<li>
    <a href="{{url('employees')}}">
       <i class="fa fa-level-up" aria-hidden="true"></i>
    </a>
</li>
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
  @if (isset($error))
    <div class="alert alert-danger rtl">
      {{$error}}
    </div>
  @endif
  @if (isset($success))
    <div class="alert alert-success rtl">
        شاغل مورد نظر ثبت گردید.<br>
        حال می‌توانید با رفتن به صفحه ویرایش شاغل اقدام به ثبت تاریخ ورود شاغل نمایید
    </div>
  @endif
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header rtl" data-background-color="purple">
                <h4 class="title">انتقال شاغل</h4>
            </div>
            <div class="card-content">
                <form action="{{url('employee-exchange')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کد‌ملی شاغل</label>
                                <input type="text" name="id_number" value="{{isset($oldInputs)? $oldInputs['id_number']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 pull-right">
                          <div class="col-md-10 col-sm-10">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                              <input type="text" id="unit" name="unit_title" class="form-control" value="{{isset($oldInputs)? $oldInputs['unit_title']: ''}}">
                            </div>
                          </div>
                          <div class="col-md-2 col-sm-2 text-center" style="margin-top: 30px;">
                            <span>کارگاه</span>
                          </div>
                          <script type="text/javascript">
                            $( function() {
                              var url = "{{url('api/units/' . Auth::user()->name)}}";
                              $.get(url, function(data, status){
                                  var jsonRes = JSON.parse(data);
                                  console.log(jsonRes);
                                  $("#unit").autocomplete({
                                      source: jsonRes
                                  });
                              });
                            });
                          </script>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($success))
                              <a class="btn btn-primary" href="{{url('employee/' . $employee->id)}}">ویرایش {{$employee->first_name}} {{$employee->last_name}}</a>
                            @endif
                            <button type="submit" class="btn btn-primary pull-right">انتقال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection