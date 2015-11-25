@extends('layouts.master')
@section('title', 'Dominios')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <header>
                <h3>Create New Domain</h3>
                <div class="text-right">
                    <a href="{{ url('/dashboard/domains') }}" class="btn btn-danger">
                        <i class="fa fa-backward"></i> Back
                    </a>
                </div>
            </header>
            <hr>
            <div class="body">
                @include('common.errors')
                <form class="form-horizontal" role="form" method="POST" action="{{ route('dashboard.domains.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="col-md-4 control-label">Domain Name: </label>
                        <div class="col-md-8">
                            <input type="text" placeholder="something.com" class="form-control" name="name" value="{{ old('name') }}">
                            <span class="small">Name of the domain</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4 ">
                            <div class="text-right">
                                <a href="{{ url('/dashboard/domains') }}" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create new domain</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
