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
        نمایش تعداد شاغلین به تفکیک جنسیت های مرد،زن و مشخص نشده(ممکن است هنگام ورود اطلاعات، جنسیت شاغل را تعیین نکرده باشند)
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header card-chart" data-background-color="green">
                <div class="ct-chart" id="reportChart"></div>
            </div>
            <div class="card-footer rtl">
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@if(isset($results))
@if(sizeof($results) > 0)
<script type="text/javascript">
    $(document).ready(function () {
        var data = {
            labels: [
                @foreach($results as $item)
                    '{{$item->gender}}',
                @endforeach
            ],
            series: [
                @foreach($results as $item)
                    {{$item->sum}},
                @endforeach
            ]
        };

        var options = {
        labelInterpolationFnc: function(value) {
                return value[0]
            }
        };

        var responsiveOptions = [
            ['screen and (min-width: 640px)', {
                chartPadding: 30,
                labelOffset: 0,
                labelDirection: 'explode',
                labelInterpolationFnc: function(value) {
                        return value;
                    }
                }],
                ['screen and (min-width: 1024px)', {
                    labelOffset: 0,
                    chartPadding: 20
                }]
            ];

        

        reportChart = new Chartist.Pie('#reportChart', data, options, responsiveOptions);
    });
</script>
@endif
@endif
@endsection