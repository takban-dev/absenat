@extends('layouts.app')

@section('title')
{{$data['title']}}
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
    </div>
</div>
@endsection

@section('scripts')

@endsection