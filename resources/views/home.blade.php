@extends('layouts.master')
@section('title', 'Home')

@section('css')
    <link href="{{ asset('/assets/css/comment.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/tasks.css') }}" rel="stylesheet">
@stop


@section('content')
    <h1>Dashboard</h1>
    <hr>
    <div class="row">
        <div class="col-md-6">@include('api.tasks.app')</div>
        {{--<div class="col-md-6">@include('comments.app')</div>--}}
    </div>
@stop


@section('js')
    <!-- AngularJS Tasks App-->
    <script src="{{asset('assets/js/tasks/directives/EnterStroke.js')}}"></script>
    <script src="{{asset('assets/js/tasks/directives/Integer.js')}}"></script>
    <script src="{{asset('assets/js/tasks/services/TaskService.js')}}"></script>
    <script src="{{asset('assets/js/tasks/controllers/TaskController.js')}}"></script>
    <script src="{{asset('assets/js/tasks/app.js')}}"></script>

    <!-- AngularJS Comments App-->
    <script src="{{asset('assets/js/comments/app-100.js')}}"></script>
@stop