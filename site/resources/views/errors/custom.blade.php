@extends('layouts.app')

@section('title')
خطای {{$status}}
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

<form class="navbar-form navbar-right" role="search">
<div class="form-group  is-empty">
<input type="text" class="form-control rtl" placeholder="جستجو">
<span class="material-input"></span>
</div>
<button type="submit" class="btn btn-white btn-round btn-just-icon">
<i class="material-icons">search</i><div class="ripple-container"></div>
</button>
</form>
</div>
</div>
@endsection

@section('content')
<div class="panel panel-default rtl">
  <div class="panel-body"><h3>خطای {{$status}}</h3></div>
  <div class="panel-footer"><h4>{{$message}}</h4></div>
</div>
@endsection