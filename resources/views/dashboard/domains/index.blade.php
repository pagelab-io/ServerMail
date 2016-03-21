@extends('layouts.master')
@section('title', 'Dominios')

@section('content')
    <div class="card-view">
        <div class="card-header">
            <h1>Dominios</h1>
            <hr>

            @include('partials.notification')

        </div>
        <div class="grid-header row">
            <div class="col-sm-8 col-xs-6">
                <a href="{!! route('dashboard.domains.create') !!}" class="btn btn-primary">
                    <i class="fa fa-plus-square"></i>
                    Crear nuevo dominio
                </a>
            </div>
            <div class="col-sm-4 col-xs-6">
                <form class="form-search" method="get" action="{{ route('dashboard.domains.index')}}" role="search" autocomplete="off">
                    <div class="form-group">
                        <label class="sr-only" for="txtSearch"></label>
                        <div class="input-group">
                            <div class="md icon input-group-addon"><i class="fa fa-search"></i></div>
                            <input type="text" class="form-control" name="name" id="txtSearch" placeholder="Buscar...">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="grid-content row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="50px">#</th>
                            <th>Dominio</th>
                            <th width="100px">Estatus</th>
                            <th width="100px">Creado</th>
                            <th width="100px">Acciones</th>
                        </tr>
                        </thead>
                    <tbody>
                        @if($domains->isEmpty())
                            <tr>
                                <td colspan="5">
                                    <p class="text-center">No hay dominios.</p>
                                </td>
                            </tr>
                        @else
                            @foreach($domains as $index => $domain)
                                <tr data-id="{{$domain->id}}">
                                    <td>{!! ++$index !!}</td>
                                    <td>
                                        <span>{!! $domain->name !!}</span>
                                        <div class="small">
                                            <a class="link-accounts" href="{!! route('dashboard.domains.accounts', $domain->id) !!}">
                                                <span>Bandejas</span>
                                                <span class="text-danger">({!! '' . $domain->accounts->count() . '' !!})</span>
                                            </a>
                                            <span>-</span>
                                            <a class="link-aliases" href="{!! route('dashboard.domains.aliases', $domain->id) !!}">
                                                <span>Forwards</span>
                                                <span class="text-danger">({!! '' . $domain->aliases->count() . '' !!})</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{!! route('dashboard.domains.toggle', $domain->id) !!}" method="post">
                                            {!! csrf_field() !!}
                                            <button class="btn btn-{!! $domain->status ? 'active' : 'inactive' !!}" type="submit" title="{!! $domain->status == 1 ? 'Switch to inactive' : 'Switch to active' !!}">
                                                <span>{!! $domain->status ? 'Activo' : 'Inactivo' !!}</span>
                                            </button>
                                        </form>

                                    </td>
                                    <td>
                                        {!! date('d-m-Y', strtotime($domain->created_at)) !!}
                                    </td>
                                    <td>
                                        <a href="{!! url('dashboard/domain/'. $domain->id . '/edit') !!}" class="btn btn-default">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="{!! url('#') !!}" id="item-{!! $domain->id !!}" class="btn btn-danger delete">
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
    </div>
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            $('a.btn.delete').on('click', function (e) {
                e.preventDefault();
                var url = '/dashboard/domains/' + $(this).attr('id').replace(/item-/, '') + '/delete',
                    row = $(this).closest("tr");

                //Show confirm and delete
                if (confirm('¿ Estas seguro de que quieres borrar el registro ? Esto sera permanente.')) {
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