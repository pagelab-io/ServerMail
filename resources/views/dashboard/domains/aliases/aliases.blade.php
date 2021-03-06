@extends('......layouts.master')
@section('title', 'Dominios')

@section('content')
    <header>
        <h1>Forwards</h1>
        <p id="domain-id" data-id="{!! $domain->id !!}" >Dominio: <strong>{{$domain->name}}</strong></p>
        <div class="text-right">
            <a href="{{ url('/dashboard/domains') }}" class="btn btn-danger">
                <i class="fa fa-backward"></i> Atras
            </a>
        </div>
    </header>
    <hr/>
    @include('......partials.notification')

    <div class="body">
        <div class="row">
            <div class="col-md-12">
                @include('......common.errors')

                <section class="forwards">

                    <p>Agregar nuevo alias</p>
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" role="form" method="POST" autocomplete="off" action="{{ route('dashboard.domains.addAlias', $domain) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Correo de origen</label>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="Correo de origen" class="form-control" name="source" value="{{ old('source') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Correo de destino</label>
                                    <div class="col-md-8">
                                        <input type="text" placeholder="Correo de destino" class="form-control" name="destination" value="{{ old('destination') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-6">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Agregar nuevo forward</button>
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
                                <th>Correo fuente</th>
                                <th>Correo destino</th>
                                <th width="100px">Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($domain->aliases->isEmpty())
                                <tr>
                                    <th colspan="4">
                                        <p class="text-center">No hay forwards.</p>
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

                var url = '/dashboard/domains/' + $(this).attr('id').replace(/item-/, '') + '/removeAlias',
                        row = $(this).closest("tr");

                //Show confirm and delete
                if (confirm('¿ Estas seguro de eliminar el forward permanentemente ?')) {
                    $.ajax({
                        data: {_token: '{!! csrf_token() !!}'},
                        url: url,
                        type: 'DELETE',
                        success: function (result) {
                            // Do something with the result
                            if (result.success == 1) {
                                row.fadeOut(200);
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    })
                }
            });
        });
    </script>
@stop