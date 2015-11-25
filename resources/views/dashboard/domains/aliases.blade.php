@extends('layouts.master')
@section('title', 'Dominios')

@section('content')
    <header>
        <h1>Alias</h1>
        <p id="domain-id" data-id="{!! $domain->id !!}" >Domain Name: <strong>{{$domain->name}}</strong></p>
        <div class="text-right">
            <a href="{{ url('/dashboard/domains') }}" class="btn btn-danger">
                <i class="fa fa-backward"></i> Back
            </a>
        </div>
    </header>
    <hr/>
    @include('partials.notification')

    <div class="body">
        <div class="row">
            <div class="col-md-12">
                @include('common.errors')

                <section class="forwards">

                    <p>Agregar nuevo alias</p>
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" role="form" method="POST" autocomplete="off" action="{{ route('dashboard.domains.addAlias', $domain) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Source</label>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="Source" class="form-control" name="source" value="{{ old('source') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Destination</label>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="Destination" class="form-control" name="destination" value="{{ old('destination') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-6">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Add new forward</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="grid-content row">
                    <div class="col-md-12">
                        <p>Alias registrados</p>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>Source</th>
                                <th>Destination</th>
                                <th width="100px">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($domain->aliases->isEmpty())
                                <tr>
                                    <th colspan="4">
                                        <p class="text-center">There is no alias.</p>
                                    </th>
                                </tr>
                            @else
                                @foreach($domain->aliases as $index => $alias)
                                    <tr data-id="{!! $alias->id !!}">
                                        <td>{!! ++$index !!}</td>
                                        <td>{!! $alias->source !!}</td>
                                        <td>{!! $alias->destination !!}</td>
                                        <td>
                                            <a href="{!! url('dashboard/accounts/'. $alias->id . '/edit') !!}" class="btn btn-default hidden">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a href="{!! url('#') !!}" id="item-{!! $alias->id !!}" class="btn btn-danger delete">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div> <!-- ends grid-content -->
                </section>
            </div>
        </div>
    </div>

@stop


@section('js')
    <!-- Angular JS App-->
    <script src="{{asset('/assets/js/domains/app.js')}}"></script>

    <script type="text/javascript">
        $(function () {

            $('.forwards a.btn.delete').on('click', function (e) {
                e.preventDefault();

                var domain_id = $('#domain-id').attr('data-id');
                var url = '/dashboard/domains/' + domain_id + '/' + $(this).attr('id').replace(/item-/, '') + '/removeAlias',
                        row = $(this).closest("tr");

                //Show confirm and delete
                if (confirm('Are you sure! it will be gone permanently.')) {
                    $.ajax({
                        data: {_token: '{!! csrf_token() !!}'},
                        url: url,
                        type: 'DELETE',
                        success: function (result) {
                            // Do something with the result
                            if (result.success == 1) {
                                row.fadeOut(200);
                            }
                        }
                    })
                }
            });
        });
    </script>
@stop