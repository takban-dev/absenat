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
        <h4 class="title">{{$title}}</h4>
    </div>
    <div class="card-content">
        <form action="{{url('admin/reports/' . $formAction)}}" method="get">
            <div class="row">
                @foreach($fields as $field)
                    <div class="col-md-{{$field['md']}} col-lg-{{$field['md']}} col-sm-{{$field['sm']}} pull-right">
                    @if($field['type'] == 'simple-input')
                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                            <label class="control-label">{{$field['title']}}</label>
                            <input type="text" value="{{isset($oldInputs)? $oldInputs[$field['name']]: ''}}" name="{{$field['name']}}" class="form-control">
                        </div>
                    @elseif($field['type'] == 'simple-select')
                        <div class="col-md-{{12 - $field['title-sz']}} col-sm-12">
                            <div class="form-group rtl col-lg-12 col-md-12">
                                <div class="form-group" style="margin-top: 0px">
                                    <select class="form-control" name="{{$field['name']}}" style="padding-top: 0px">
                                        @foreach($field['values'] as $value)
                                            <option value="{{$value->id}}" {{isset($oldInputs)?($value->id==$oldInputs[$field['name']]?'selected':''):''}}>{{$value->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-{{$field['title-sz']}} col-sm-12 text-center pull-right" style="margin-top: 30px;">
                            <span>{{$field['title']}}</span>
                        </div>
                    @elseif($field['type'] == 'autocomplete')
                        <div class="col-md-{{12 - $field['title-sz']}} col-sm-12">
                            <div class="form-group label-floating rtl col-lg-12 col-md-12">
                                <input type="text" id="{{$field['name']}}" name="{{$field['name']}}" value="{{isset($oldInputs)? $oldInputs[$field['name']]: ''}}" class="form-control">
                            </div
        >                            </div>
                        <div class="col-md-{{$field['title-sz']}} col-sm-12 text-center" style="margin-top: 30px;">
                            <span>{{$field['title']}}</span>
                        </div>
                        <script type="text/javascript">
                            $( function() {
                                var url = "{{url('api/' . $field['query'])}}";
                                $.get(url, function(data, status){
                                    var jsonRes = JSON.parse(data);
                                    $("#{{$field['name']}}").autocomplete({
                                        source: jsonRes
                                    });
                                });
                            });
                        </script>
                    @elseif($field['type'] == 'number')
                        <div class="form-group label-floating rtl col-lg-12 col-md-12">
                            <label class="control-label">{{$field['title']}}</label>
                            <input type="number" value="{{isset($oldInputs)? $oldInputs[$field['name']]: ''}}" name="{{$field['name']}}" class="form-control">
                        </div>
                    @endif
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-12 col-lg-2 pull-right">
                    <button type="submit" class="btn btn-primary pull-right" style="margin-top: 3rem;">مشاهده لیست</button>
                </div>
            </div>
        </form>

@if(isset($results))
        <table class="table table-hover text-center">
            <thead>
                @foreach($headers as $key=>$value)
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