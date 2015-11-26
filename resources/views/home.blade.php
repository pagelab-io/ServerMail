@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <h1>Dashboard</h1>
    <hr>

    <div class="row">
        <!--<div class="col-md-6">@include('todos.index')</div>-->
        <div class="col-md-6">@include('comments.index')</div>
    </div>
@stop

@section('js')
    <!-- AngularJS
    <script src="{{asset('assets/js/todos/app.js')}}"></script> -->
    <script src="{{asset('assets/js/comments/app.js')}}"></script>
@stop