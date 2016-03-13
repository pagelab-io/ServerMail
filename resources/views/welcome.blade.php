@extends('layouts.master')
@section('title', 'Bienvenido')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="cover">

                @include("auth.login")

            </div>
        </div>
    </div>
@stop