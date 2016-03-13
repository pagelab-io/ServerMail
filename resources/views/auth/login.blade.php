@extends('layouts.default')
@section('title', 'Login')

@section('content')
	<div class="row login-view">
		<div class="col-md-6 col-md-offset-3">

			@include('common.errors')
			<br>
			@include('partials.notification')

            <h1 style="text-align:center;">Bienvenido a ServerMail</h1>
            <br>
			<div class="panel panel-default">
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="{{ route('auth.login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}"><!--no se para que es esta funcion-->

						<div class="form-group">
							<label class="col-md-4 control-label">Correo electrónico</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
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
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Recordarme
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Inicia sesión</button>
								<a class="btn btn-link" href="{{ route('auth.recovery') }}">¿Olvidaste tu contraseña?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop
