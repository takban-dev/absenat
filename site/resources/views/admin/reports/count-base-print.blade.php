@extends('layouts.print')

@section('title')
{{$title}}
@endsection

@section('content')
@if(isset($results))
    @if(sizeof($results) > 0)
        <div class="ct-chart" id="chart"></div>
        <div class="row">
            <table class="table table-hover text-center">
                <thead>
                    <th class="rtl text-center">
                        ردیف
                    </th>
                    @foreach($columns as $column)
                        <th class="rtl text-center">
                            <a href="{{$query . '&sort=' . $column->name}}">{{$column->title}}</a>
                        </th>
                    @endforeach
                    <th class="rtl text-center">
                        <a href="{{$query . '&sort=count'}}">تعداد</a>
                    </th>
                </thead>
                <tbody>
                    <?php 
                        $rowNumber = 1; 
                        $chart_cols = array(); 
                        $chart_vals = array();
                    ?>
                    @foreach($results as $row)
                        <tr>
                            <td>{{$rowNumber}}</td>
                            @foreach($row as $item)
                                <td>{{$item}}</td>
                                <?php $last = $item ?>
                            @endforeach
                        </tr>    
                        <?php 
                            $rowNumber++; 
                            array_push($chart_cols, $rowNumber-1);
                            array_push($chart_vals, $last);
                        ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
            @if($chart_type == 1)
                md.startAnimationForLineChart(
                    new Chartist.Bar('.ct-chart', {
                        labels: {{json_encode($chart_cols)}},
                        series: {{json_encode($chart_vals)}}
                        
                    }, {
                        distributeSeries: true
                    }));
            @elseif($chart_type == 2)
                <?php
                    $labels = array();
                    $sum = 0;
                    for($i=0; $i<sizeof($chart_vals); $i++)
                        $sum += $chart_vals[$i];

                    for($i=0; $i<sizeof($chart_vals); $i++)
                        array_push($labels, $chart_cols[$i] . ': ' . intval(($chart_vals[$i]/$sum)*100) . '%');
                ?>
                var data = {
                  labels: [
                    @foreach($labels as $label)
                        '{{$label}}',
                    @endforeach
                  ],
                  series: {{json_encode($chart_vals)}},
                };

                var options = {
                  labelInterpolationFnc: function(value) {
                    return value[0]
                  },
                  height: 400
                };

                var responsiveOptions = [
                  ['screen and (min-width: 640px)', {
                    chartPadding: 30,
                    labelOffset: 10,
                    labelDirection: 'explode',
                    labelInterpolationFnc: function(value) {
                      return value;
                    }
                  }],
                  ['screen and (min-width: 1024px)', {
                    labelOffset: 80,
                    chartPadding: 20
                  }]
                ];

                md.startAnimationForLineChart(new Chartist.Pie('.ct-chart', data, options, responsiveOptions));
            @endif
            
        </script>
    @else
        <div class="row text-center">
            هیچ رکوردی برای گزارش دهی یافت نشد
        </div>
    @endif
@endif
@endsection

@section('scripts')

@endsection