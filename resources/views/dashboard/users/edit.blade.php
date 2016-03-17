@extends('layouts.master')
@section('title', 'Usuarios')
@section('content')
    <h1>Usuario: {{$user->name}}</h1>
    <hr/>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Datos del usuario</div>
                <div class="panel-body">

                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('dashboard.users.update', $user) }}">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Nombre</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{!! $user->name !!}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Correo electrónico</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{!! $user->email !!}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Contraseña</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ url('/dashboard/users') }}" class="btn btn-default">Cancelar</a>
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop