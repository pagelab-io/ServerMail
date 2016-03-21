@extends('layouts.master')
@section('title', 'Dominios')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <header>
                <h3>Crear nuevo dominio</h3>
                <div class="text-right">
                    <a href="{{ url('/dashboard/domains') }}" class="btn btn-danger">
                        <i class="fa fa-backward"></i> Atrás
                    </a>
                </div>
            </header>
            <hr>
            <div class="body">
                @include('common.errors')
                <form class="form-horizontal" role="form" method="POST" action="{{ route('dashboard.domains.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Nombre del dominio: </label>
                        <div class="col-md-8">
                            <input type="text" placeholder="dominio.com" class="form-control" name="name" value="{{ old('name') }}">
                            <span class="small">Nombre del dominio</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4 ">
                            <div class="text-right">
                                <a href="{{ url('/dashboard/domains') }}" class="btn btn-default">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Crear nuevo dominio</button>
                            </div>
                        </div>
                    </div>
                /form>
            </div>
        </div>
    </div>

@stop
