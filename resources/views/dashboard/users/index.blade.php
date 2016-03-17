@extends('layouts.master')
@section('title', 'Usuarios')

@section('content')
    <div class="card-view">

        <div class="card-header">
            <h1>Usuarios</h1>
            <hr>
        </div>

        <div class="grid-header row">
            <div class="col-sm-8 col-xs-6">
                <a href="{!! route('dashboard.users.create') !!}" class="btn btn-primary">
                    <i class="fa fa-plus-square"></i> Crear nuevo usuario
                </a>
            </div>
            <div class="col-sm-4 col-xs-6">
                <form accept-charset="UTF-8" class="form-search" method="get" action="{!! route('dashboard.users.index') !!}" autocomplete="off">
                    <div class="form-group">
                        <label class="sr-only" for="txtSearch"></label>
                        <div class="input-group">
                            <div class="md icon input-group-addon"><i class="fa fa-search"></i></div>
                            <input type="search" class="form-control" value="{{Request::get('name')}}" id="txtSearch" placeholder="Search...">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <br>

        <div class="grid-content row">
            <div class="col-md-12">

                @include('partials.notification')

                @if($users->isEmpty())
                    <p>There is no user.</p>
                @else
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="50px">ID</th>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Estatus</th>
                                <th width="120px">Acciones</th>
                            </tr>
                            </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                <tr data-id="{{$user->id}}">
                                    <td>{!! ++$index !!}</td>
                                    <td>
                                        <a href="{!! route('dashboard.users.edit', $user->id) !!}">{!! $user->name !!}</a>
                                    </td>
                                    <td>{!! $user->email !!}</td>
                                    <td>{!! $user->active ? 'Activo' : 'Inactivo' !!}</td>
                                    <td>
                                        <a href="{!! url('dashboard/users/'. $user->id . '/edit') !!}" class="btn btn-default">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="{!! url('#') !!}" id="item-{!! $user->id !!}" class="btn btn-danger delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-center">
                        {!! $users->appends(Request::get('name'))->render() !!}
                    </div>
                @endif
            </div>
        </div> <!-- ends grid-content -->
    </div>
@stop

@section('js')
    <script type="text/javascript">
        $(function () {
            $('a.btn.delete').on('click', function (e) {
                e.preventDefault();
                var url = '/dashboard/users/' + $(this).attr('id').replace(/item-/, '') + '/delete',
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

                            alert(result.message);
                        },
                        error: function (response, responseText, status) {
                            //console.log(response)
                        }
                    })
                }
            });
        });
    </script>
@stop