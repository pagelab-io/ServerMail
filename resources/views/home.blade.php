@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <h1>Dashboard</h1>
    <hr>

    @include('todos.index')

@stop

@section('js')
        <!--AngularJS-->
    <script src="{{asset('assets/js/todos/app.js')}}"></script>
@stop