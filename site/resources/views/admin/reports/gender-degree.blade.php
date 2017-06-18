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
        <h4 class="title">تعداد شاغلین به تفکیک جنسیت و مدرک تحصیلی</h4>
    </div>
    <div class="card-content">
        <table class="table table-hover">
            <thead>
                <th class="rtl">جنسیت</th>
                <th class="rtl">مدرک تحصیلی</th>
                <th class="rtl">تعداد</th>
            </thead>
            <tbody>
                @foreach($results as $row)
                    <tr>
                    <td>{{$row->gender}}</td>
                    <td>{{$row->degree}}</td>
                    <td>{{$row->sum}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')

@if(isset($results))
@if(sizeof($results) > 0)
<script type="text/javascript">
    $(document).ready(function () {
        var labels = [];
        var series = [
                [
                @foreach($results as $item)
                    {{$item->sum}},
                @endforeach
                ]
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