@extends('layouts.master')
@section('title', 'Home')

@section('css')
    <link href="{{ asset('/assets/css/comment.css') }}" rel="stylesheet">
@stop

@section('content')
    <h1>Dashboard</h1>
    <hr>
    <div class="row">
        <div class="col-md-6">@include('todos.app')</div>
        <div class="col-md-6">@include('comments.app')</div>
    </div>
@stop

@section('js')
    <!-- AngularJS  -->
    <script src="{{asset('assets/js/todos/app.js')}}"></script>
    <script src="{{asset('assets/js/todos/services.js')}}"></script>
    <script src="{{asset('assets/js/comments/app-100.js')}}"></script>
@stop