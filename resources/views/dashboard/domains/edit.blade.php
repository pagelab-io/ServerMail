@extends('layouts.master')
@section('title', 'Dominios')
@section('content')
    <h1>{{$domain->name}}</h1>
    <hr/>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Datos del dominio</div>
                <div class="panel-body">

                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('dashboard.domains.update', $domain) }}">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Nombre</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{!! $domain->name !!}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ url('/dashboard/domains') }}" class="btn btn-default">Cancelar</a>
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