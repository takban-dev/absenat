@extends('layouts.app')

@section('title')
آمار ها
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
<div class="card">
    <div class="card-header rtl" data-background-color="purple">
        <h4 class="title">گزارشات</h4>
    </div>
    <div class="card-content">
        <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
                @foreach($filters as $key => $value)
                    <button class="btn btn-primary" data-toggle="collapse" data-target="#{{$key}}"  >{{$value['title']}}</button>
                @endforeach
            </div>
        </div>
        <form action="{{url('admin/reports')}}" method="post">
            {{ csrf_field() }}
            <div class="row">
                @foreach($filters as $key => $value)
                    <div id="{{$key}}" class="collapse col-md-12 col-lg-12 col-sm-12">
                        <div class="panel panel-default rtl">
                            <div class="panel-heading">{{$value['title']}}</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-12 pull-right">
                                        <div class="checkbox">
                                            <label class="nrtl">
                                                <input type="checkbox" name="{{$key}}:dct" {{isset($oldInputs[$key . ':dct']) && $oldInputs[$key . ':dct'] == 'on' ?'checked': ''}}>
                                            </label>
                                            نمایش به تفکیک
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach($value['data'] as $item)
                                    <div class="col-md-3 col-lg-3 col-sm-6 pull-right">
                                        <div class="checkbox">
                                            <label class="nrtl">
                                                <input type="checkbox" name="{{$key}}:{{$item->id}}" {{isset($oldInputs[$key . ':' . $item->id]) ?'checked': ''}}>
                                            </label>
                                            {{$item->title}}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="btn btn-primary pull-right" type="submit" name="show" value="yes">نمایش گزارش</button>
            <button class="btn btn-primary pull-right" type="submit" name="print" value="yes">تولید نسخه چاپی</button>
        </form>
    </div>
</div>
@if(isset($results))
@if(sizeof($results['data']) == 0)
    هیچ گزارشی قابل دریافت نیست
@else
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header card-chart" data-background-color="green">
                <div class="ct-chart" id="reportChart"></div>
            </div>
            <div class="card-content rtl">
                <h4 class="title">تعداد کارکنان به تفکیک جنسیت در سال های اخیر</h4>
                <h6>(قرمز: مرد، سفید: زن)</h6>
            </div>
            <div class="card-footer rtl">
                <table class="table table-hover">
                    <thead>
                        @foreach($results['headers'] as $header)
                            <th class="rtl">{{$header}}</th>
                        @endforeach
                    </thead>
                    <tbody>
                        @foreach($results['data'] as $row)
                            <tr>
                                @foreach($row as $item)
                                    <td>{{$item}}</td>
                                @endforeach
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endsection

@section('scripts')

@if(isset($results))
@if(sizeof($results['data']) > 0)
<script type="text/javascript">
    $(document).ready(function () {
        var series = [
            @foreach($results['chart']['series'] as $item)
                '{{$item}}',
            @endforeach
        ];
        var data = [
            @foreach($results['chart']['data'] as $item)
                {{$item}},
            @endforeach
        ];
        jsData.initCharts(series, data);
    });
</script>
@endif
@endif
@endsection