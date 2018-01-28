@extends('layouts.print')

@section('title')
{{$title}}
@endsection

@section('back')
<li>
    <a href="{{url('admin/reports')}}">
       <i class="fa fa-level-up" aria-hidden="true"></i>
    </a>
</li>
@endsection

@section('content')
@if(isset($results))
    @if(sizeof($results) > 0)
        <div class="row">
            <table class="table table-hover text-center">
                <thead>
                    <th class="rtl text-center">ردیف</th>
                    @foreach($columns as $column)
                        <th class="rtl text-center">
                            <a href="{{$query . '&sort=' . $column->name}}">{{$column->title}}</a>
                        </th>
                    @endforeach
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    @foreach($results as $row)
                        <tr>
                            <td>{{$count+1}}</td>
                            @foreach($row as $item)
                                <td>{{$item}}</td>
                            @endforeach
                        </tr>    
                        <?php $count++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="row text-center">
            هیچ رکوردی برای گزارش دهی یافت نشد
        </div>
    @endif
@endif
@endsection

@section('scripts')

@endsection