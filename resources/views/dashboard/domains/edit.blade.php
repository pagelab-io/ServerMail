@extends('layouts.master')
@section('title', 'Dominios')
@section('content')
    <h1>Domain Name: {{$domain->name}}</h1>
    <hr/>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Domain Data</div>
                <div class="panel-body">

                    @include('common.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('dashboard.domains.update', $domain) }}">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{!! $domain->name !!}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="{{ url('/dashboard/domains') }}" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop