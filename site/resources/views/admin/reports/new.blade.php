@extends('layouts.app')

@section('title')
فرم گزارش
@endsection


@section('back')
<li>
    <a href="{{url('admin/report-new')}}">
        <i class="material-icons">keyboard_return</i>
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
                <h4 class="title">فرم گزارش گیری جدید</h4>
            </div>
            <div class="card-content">
                <form action="{{url('admin/report-new')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pull-right">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <label class="control-label">عنوان فرم گزارش</label>
                                <input type="text" value="{{isset($oldInputs)? $oldInputs['title']: ''}}" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 pull-right">
                            <div class="col-md-8">
                                <div class="form-group rtl col-lg-12 col-md-12">
                                    <div class="form-group" style="margin-top: 0px">
                                        <select class="form-control" name="type" style="padding-top: 0px">
                                            <option value="1" {{isset($oldInputs)?(1==$oldInputs['type']?'selected':''):''}}>تعداد</option>
                                            <option value="2" {{isset($oldInputs)?(2==$oldInputs['type']?'selected':''):''}}>لیست</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center" style="margin-top: 30px;">
                                <span>نوع فرم گزارش</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading rtl">فیلد ها</div>
                                <div class="panel-body">
                                    @foreach($columns as $key=>$value)
                                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                            <div class="checkbox pull-right">
                                                <span>{{$value}}</span>
                                                <label>
                                                    <input type="checkbox" name="fld-{{$key}}" {{isset($oldInputs['fld-' . $key]) && $oldInputs['fld-' . $key] == 1 ?'checked': ''}}>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading rtl">ستون ها</div>
                                <div class="panel-body">
                                    @foreach($columns as $key=>$value)
                                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                            <div class="checkbox pull-right">
                                                {{$value}}
                                                <label>
                                                    <input type="checkbox" name="col-{{$key}}" {{isset($oldInputs['col-' . $key]) && $oldInputs['col-' . $key] == 1 ?'checked': ''}}>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading rtl">محدودیت ها</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <table class="table rtl">
                                            <thead class="text-primary">
                                                <th class="rtl">فیلد</th>
                                                <th class="rtl">نوع شرط</th>
                                                <th class="rtl">مقدار</th>
                                            </thead>
                                            <tbody>
                                                @foreach($columns as $key=>$value)

                                                    @for($i=0; $i<3; $i++)
                                                    <tr>
                                                        <td>{{$value}}</td>
                                                        <td>
                                                            <select class="form-control" name="{{$key}}_op_{{$i}}"
                                                                style="padding-top: 0px">
                                                                <option value = ">"  {{isset($oldInputs[$key . '_op_' . $i]) && $oldInputs[$key . '_op_' . $i] == '>' ?'selected': ''}}>بزرگتر</option>
                                                                <option value = "<"  {{isset($oldInputs[$key . '_op_' . $i]) && $oldInputs[$key . '_op_' . $i] == '<' ?'selected': ''}}>کوچکتر</option>
                                                                <option value = "="  {{isset($oldInputs[$key . '_op_' . $i]) && $oldInputs[$key . '_op_' . $i] == '=' ?'selected': ''}}>برابر</option>
                                                                <option value = "<>" {{isset($oldInputs[$key . '_op_' . $i]) && $oldInputs[$key . '_op_' . $i] == '<>' ?'selected': ''}}>نابرابر</option>
                                                            </select>
                                                        </td>
                                                        @if($values[$key]['type'] == 'text')
                                                        <td>
                                                            <input type="text" value="" placeholder="مقدار" 
                                                                name="{{$key}}_vl_{{$i}}" class="form-control">
                                                        </td>
                                                        @elseif($values[$key]['type'] == 'select')
                                                        <td>
                                                            <select class="form-control" name="{{$key}}_op_{{$i}}"
                                                                style="padding-top: 0px">
                                                                <option value = "0" {{isset($oldInputs[$key . '_op_' . $i]) && $oldInputs[$key . '_op_' . $i] == 0 ?'selected': ''}}>مقدار</option>
                                                                @foreach($values[$key]['val'] as $row)
                                                                    <option value = "{{$row->id}}">{{$row->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    @endfor
                                                @endforeach
                                                <tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">ثبت فرم گزارش</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection