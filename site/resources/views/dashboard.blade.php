@extends('layouts.app')

@section('title')
داشبورد
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">people</i>
            </div>
            <div class="card-content">
                <p class="category">شاغلین</p>
                <h3 class="title">{{$employeeCount}}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">business_center</i>
            </div>
            <div class="card-content">
                <p class="category">واحد ها</p>
                <h3 class="title">{{$unitCount}}</h3>
            </div>
        </div>
    </div>
    @if($group_code == 1)
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header" data-background-color="blue">
                    <i class="material-icons">person</i>
                </div>
                <div class="card-content">
                    <p class="category">کاربران</p>
                    <h3 class="title">{{$userCount}}</h3>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection