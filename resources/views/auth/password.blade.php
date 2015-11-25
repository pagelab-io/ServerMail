@extends('layouts.master')
@section('title', 'Recovery Password')
@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Recovery Password</h1>
			<hr>
			@include('common.errors')
			<br>
			@include('partials.notification')

			<div class="form-container">
				<form class="form-horizontal" role="form" method="POST" action="{{ route('auth.recovery') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group">
						<label class="col-md-4 control-label">E-Mail Address</label>
						<div class="col-md-6">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="btn btn-primary">
								Send Password Reset Link
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
