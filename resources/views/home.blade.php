@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <h1>Dashboard</h1>

    @include('todos.index');
@stop
