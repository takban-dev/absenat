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
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header card-chart" data-background-color="green">
                <div class="ct-chart" id="reportChart"></div>
                <h4 class="title">{{$title}}</h4>
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
                    '{{$item->field}}',
                @endforeach
            ],
            series: [
                @foreach($results as  $item)
                    {{$item->sum}},
                @endforeach
            ]
        };

        new Chartist.Bar('.ct-chart', {
            labels: [
            @foreach($results as $item)
                    '{{$item->gender}}',
                @endforeach
                ],
            series: [
                [5, 4, 3, 7],
                [3, 2, 9, 5],
                [1, 5, 8, 4],
                [2, 3, 4, 6],
                [4, 1, 2, 1]
                ]
            }, {
                // Default mobile configuration
                stackBars: true,
                axisX: {
                    labelInterpolationFnc: function(value) {
                        return value.split(/\s+/).map(function(word) {
                            return word[0];
                        }).join('');
                    }
                },
                axisY: {
                    offset: 20
                }
            }, [
            // Options override for media > 400px
            ['screen and (min-width: 400px)', {
                    reverseData: true,
                    horizontalBars: true,
                axisX: {
                    labelInterpolationFnc: Chartist.noop
                },
                axisY: {
                    offset: 60
                }
            }],
            // Options override for media > 800px
            ['screen and (min-width: 800px)', {
                stackBars: false,
                seriesBarDistance: 10
            }],
            // Options override for media > 1000px
            ['screen and (min-width: 1000px)', {
                    reverseData: false,
                    horizontalBars: false,
                    seriesBarDistance: 15
                }]
            ]);
        });
</script>
@endif
@endif
@endsection