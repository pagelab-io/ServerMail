@extends('.........layouts.master')
@section('title', 'Dominios')

@section('content')
    <header>
        <h1>Bandejas</h1>
        <p id="domain-id" data-id="{!! $domain->id !!}" >Dominio: <strong>{{$domain->name}}</strong></p>
        <div class="text-right">
            <a href="{{ url('/dashboard/domains') }}" class="btn btn-danger">
                <i class="fa fa-backward"></i> Atras
            </a>
        </div>
    </header>

    <hr/>

    @include('.........partials.notification')

    <div class="body">
        <div class="row">
            <div class="col-md-12">
                @include('.........common.errors')

                <section class="accounts">
                    <p>Agregar nueva bandeja</p>
                    <div class="row">
                        <div class="col-md-12">
                            <form ng-app="domainRegisterApp" ng-controller="DomainRegister" class="form-horizontal" role="form" method="POST" autocomplete="off" action="{{ route('dashboard.domains.addAccount', $domain) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Correo</label>
                                    <div class="col-md-8">
                                        <input type="text" ng-model="name" placeholder="Correo" class="form-control" name="name" value="{{ old('name') }}">
                                        <output class="email">@{{name}}{!! '@' . $domain->name!!}</output>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Contraseña</label>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="password" placeholder="Contraseña">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-6">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Agregar bandeja</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="grid-content row">
                        <div class="col-md-12">
                            <p>Cuentas registradas: {!! $domain->accounts->count() !!}</p>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="50px">ID</th>
                                        <th>Cuenta</th>
                                        <th width="100px">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($domain->accounts->isEmpty())
                                        <tr>
                                            <th colspan="3">
                                                <p class="text-center">No hay bandejas.</p>
                                            </th>
                                        </tr>
                                    @else
                                        @foreach($domain->accounts as $index => $account)
                                            <tr data-id="{!! $account->id !!}">
                                                <td>{!! ++$index !!}</td>
                                                <td>{!! $account->email !!}</td>
                                                <td>
                                                    <a href="{!! url('dashboard/accounts/'. $account->id . '/edit') !!}" class="btn btn-default hidden">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="{!! url('#') !!}" id="item-{!! $account->id !!}" class="btn btn-danger delete">
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

    <!-- JQuery JS App-->
    <script type="text/javascript">
        $(function () {
            $('.accounts a.btn.delete').on('click', function (e) {
                e.preventDefault();

                var url = '/dashboard/domains/' + $(this).attr('id').replace(/item-/, '') + '/removeAccount',
                        row = $(this).closest("tr");

                //Show confirm and delete
                if (confirm('¿ Estas seguro de eliminar la bandeja, esto sera permanente ?')) {
                    $.ajax({
                        data: {_token: '{!! csrf_token() !!}'},
                        url: url,
                        type: 'DELETE',
                        success: function (result) {
                            console.log(result);
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