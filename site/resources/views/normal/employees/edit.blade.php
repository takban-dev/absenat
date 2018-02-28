@extends('layouts.app')

@section('title')
{{$oldInputs['first_name'] . ' ' . $oldInputs['last_name']}}
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
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header rtl" data-background-color="purple">
                <h4 class="title">{{$oldInputs['first_name'] . ' ' . $oldInputs['last_name']}}</h4>
                <a href="{{url('employee-single-print/' . $oldInputs['id'])}}" target="_blank">
                   <i class="fa fa-print" aria-hidden="true"></i>
                </a>

            </div>
            <div class="card-content">
                <form action="{{url('admin/employee/' . $oldInputs['id'])}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4 col-sm-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام</label>
                                <input type="text" name="first_name" value="{{isset($oldInputs)? $oldInputs['first_name']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام خانوادگی</label>
                                <input type="text" name="last_name" value="{{isset($oldInputs)? $oldInputs['last_name']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="gender" style="padding-top: 0px">
                                            @foreach ($genders->all() as $gender)
                                                    <option value="{{$gender->id}}" {{isset($oldInputs)?($gender->id==$oldInputs['gender']?'selected':''):''}}>{{$gender->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>جنسیت</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">کد ملی</label>
                                <input type="text" name="id_number" value="{{isset($oldInputs)? $oldInputs['id_number']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">نام پدر</label>
                                <input type="text" name="father_name" value="{{isset($oldInputs)? $oldInputs['father_name']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 pull-right">
                                <div class="col-md-3 col-sm-3">
                                    <select class="form-control" name="birth_date_day" style="padding-top: 0px">
                                        @for ($i=1; $i<=31; $i++)
                                            <option value="{{$i}}" {{isset($oldInputs['birth_date_day'])? ($i == $oldInputs['birth_date_day'] ? 'selected': '' ): ''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <select class="form-control" name="birth_date_month" style="padding-top: 0px">
                                        @foreach($months as $key => $val)
                                            <option value="{{$key}}" {{isset($oldInputs['birth_date_month'])? ($key == $oldInputs['birth_date_month'] ? 'selected': '' ): ''}} >{{$val}}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <select class="form-control" name="birth_date_year" style="padding-top: 0px">
                                        @for ($i=1300; $i<1388; $i++)
                                            <option value="{{$i}}" {{isset($oldInputs['birth_date_year'])? ($i == $oldInputs['birth_date_year'] ? 'selected': '' ): ''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-3 text-center" style="margin-top: 30px;">
                                    <span>تاریخ تولد</span>
                                </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">محل تولد</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['birth_place']: ''}}" name="birth_place" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="habitate" style="padding-top: 0px">
                                            @foreach ($habitates->all() as $habitate)
                                                <option value="{{$habitate->id}}" {{isset($oldInputs)?($habitate->id==$oldInputs['habitate']?'selected':''):''}}>{{$habitate->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>محل سکونت</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-8 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">سال های سکونت</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['habitate_years']: ''}}" name = "habitate_years" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="degree" style="padding-top: 0px">
                                            @foreach ($degrees->all() as $degree)
                                                <option value="{{$degree->id}}" {{isset($oldInputs)?($degree->id==$oldInputs['degree']?'selected':''):''}}>{{$degree->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>مدرک تحصیلی</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                          <div class="col-md-10 col-sm-10">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <input type="text" id="field" name="field_title" value="{{isset($oldInputs)? $oldInputs['field_title']: ''}}" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-2 col-sm-2 text-center" style="margin-top: 30px;">
                              <span>رشته تحصیلی</span>
                          </div>
                          <script type="text/javascript">
                              $( function() {
                                  var url = "{{url('api/study_fields')}}";
                                  $.get(url, function(data, status){
                                      var jsonRes = JSON.parse(data);
                                      console.log(jsonRes);
                                      $("#field").autocomplete({
                                          source: jsonRes,
                                          change: function (event, ui) {
                                              if(!ui.item){
                                                  $("#field").val("");
                                              }
                                          }
                                      });
                                  });
                              });
                          </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">تعداد افراد تحت تکفل</label>
                                <input type="text" name="dependents" value="{{isset($oldInputs)? $oldInputs['dependents']: ''}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="marrige" style="padding-top: 0px">
                                            @foreach ($marriges->all() as $marrige)
                                                <option value="{{$marrige->id}}" {{isset($oldInputs)?($marrige->id==$oldInputs['marrige']?'selected':''):''}}>{{$marrige->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>تاهل</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">مدت سابقه کار(ماه)</label>
                                <input type="text" name="experience" value="{{isset($oldInputs)? $oldInputs['experience']: ''}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">آدرس دقیق محل سکونت</label>
                                <input type="text" name="address" value="{{isset($oldInputs)? $oldInputs['experience']: ''}}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="col-md-8 col-sm-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="job" style="padding-top: 0px">
                                            @foreach ($job_fields->all() as $job)
                                                <option value="{{$job->id}}" {{isset($oldInputs)?($job->id==$oldInputs['job']?'selected':''):''}}>{{$job->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>عنوان شغلی</span>
                            </div>
                        </div>
                        <div class="col-md-6- col-sm-6">
                            <div class="col-md-10 col-sm-10">
                                <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                    <label class="control-label">مدت سابقه کار(ماه)</label>
                                    <input type="text" id="unit" name="unit_title" value="{{isset($oldInputs)? $oldInputs['unit_title']: ''}}" class="form-control">
                                </div
>                            </div>
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
                            <button type="submit" class="btn btn-primary pull-right">ثبت تغییرات شاغل</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header rtl" data-background-color="purple">
                <h4 class="title">سوابق کاری</h4>
            </div>
            <div class="card-content center">
              @if(sizeof($oldInputs['work_history']))
                @foreach($oldInputs['work_history'] as $track)
                  <div class="row">
                    <form method="POST">
                      {{csrf_field()}}
                      <input hidden name="track_id" value="{{$track->id}}" />
                      <div class="col-md-4 col-sm-4">
                        <a href="{{url('admin/employee/tracks/remove/' . $track->id)}}">
                          <button type="button" style="margin-top: 15px" class="btn btn-primary pull-left">حذف</button>
                        </a>
                        <button type="submit" style="margin-top: 15px" name="track" value="edit" class="btn btn-primary pull-left">ثبت</button>
                      </div>
                      <div class="col-md-3 col-sm-12 pull-right">
                          <div class="col-md-10 col-sm-10">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                              <input type="text" id="unit_track_{{$track->id}}" value="{{$track->title}}" name="unit_track_title_{{$track->id}}" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-2 col-sm-2 text-center" style="margin-top: 30px;">
                            <span>کارگاه</span>
                          </div>
                          <script type="text/javascript">
                            $( function() {
                              var url = "{{url('api/units')}}";
                              $.get(url, function(data, status){
                                var jsonRes = JSON.parse(data);
                                $("#unit_track_{{$track->id}}").autocomplete({
                                  source: jsonRes,
                                  change: function (event, ui) {
                                    if(!ui.item){
                                      $("#unit_track_{{$track->id}}").val("");
                                    }
                                  }
                                });
                              });
                            });
                          </script>
                      </div>
                      <div class="col-md-3 col-sm-8 pull-right">
                        <div class="col-md-4">
                          <select class="form-control" name="track_date_day_{{$track->id}}" style="padding-top: 0px">
                              @for ($i=1; $i<=31; $i++)
                                  <option value="{{$i}}" {{$track->time['mday'] == $i? 'selected': ''}}>{{$i}}</option>
                              @endfor
                          </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" name="track_date_month_{{$track->id}}" style="padding-top: 0px">
                                @foreach($months as $key => $val)
                                    <option value="{{$key}}" {{$track->time['mon'] == $i? 'selected': ''}} >{{$val}}</option>    
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" name="track_date_year_{{$track->id}}" style="padding-top: 0px">
                                @for ($i=1390; $i<1400; $i++)
                                    <option value="{{$i}}" {{$track->time['year'] == $i? 'selected': ''}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-8 pull-right">
                        <div class="col-md-12">
                          <select class="form-control" name="track_type_{{$track->id}}" style="padding-top: 0px">
                            <option value="1" {{$track->type == 1?'selected': ''}}>ورود</option>
                            <option value="2" {{$track->type == 2?'selected': ''}}>خروج</option>
                          </select>
                        </div>
                      </div>
                    </form>
                  </div>
                @endforeach
              @else
              @endif
              <div class="row">
                <form method="POST">
                  {{csrf_field()}}
                  <div class="col-md-1 col-sm-4">
                    <button type="submit" style="margin-top: 15px" name="track" value="new" class="btn btn-primary pull-left">ثبت</button>
                  </div>
                  <div class="col-md-5 col-sm-12 pull-right">
                      <div class="col-md-10 col-sm-10">
                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                          <input type="text" id="unit_track" name="unit_track_title" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-2 text-center" style="margin-top: 30px;">
                        <span>کارگاه</span>
                      </div>
                      <script type="text/javascript">
                        $( function() {
                          var url = "{{url('api/units/' . Auth::user()->name)}}";
                          $.get(url, function(data, status){
                              console.log('testing')
                              var jsonRes = JSON.parse(data);
                              console.log(jsonRes);
                              $("#unit_track").autocomplete({
                                  source: jsonRes
                              });
                          });
                        });
                      </script>
                  </div>
                  <div class="col-md-4 col-sm-8 pull-right">
                    <div class="col-md-4">
                      <select class="form-control" name="track_date_day" style="padding-top: 0px">
                          @for ($i=1; $i<=31; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                          @endfor
                      </select>
                    </div>
                    <div class="col-md-4">
                      <select class="form-control" name="track_date_month" style="padding-top: 0px">
                        @foreach($months as $key => $val)
                          <option value="{{$key}}" >{{$val}}</option>    
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <select class="form-control" name="track_date_year" style="padding-top: 0px">
                        @for ($i=1390; $i<1400; $i++)
                          <option value="{{$i}}">{{$i}}</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-8 pull-right">
                    <div class="col-md-12">
                      <select class="form-control" name="track_type" style="padding-top: 0px">
                        <option value="1">ورود</option>
                        <option value="2">خروج</option>
                      </select>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection