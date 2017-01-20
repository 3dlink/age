@extends('auth')

@section('template_title')
Reset Password
@endsection

@section('content')
<div class="mdl-layout mdl-js-layout mdl-color--grey-100 mdl-auth-form">
	<main class="mdl-layout__content">
		<div class="mdl-card mdl-shadow--2dp">
			<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text text-center full-span block">

					{{ Lang::get('titles.resetPword') }}

				</h2>
			</div>
			<div class="mdl-card__supporting-text">

				{!! Form::open(array('url' => url('/password/reset'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form')) !!}
				{!! csrf_field() !!}
				{!! Form::hidden('token', $token) !!}

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('email') ? 'is-invalid' :'' }}">
					{!! Form::email('email', null, array('id' => 'email', 'class' => 'mdl-textfield__input', )) !!}
					{!! Form::label('email', Lang::get('auth.email') , array('class' => 'mdl-textfield__label')); !!}
					<span class="mdl-textfield__error">Please Enter a Valid {{ Lang::get('auth.email') }}</span>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password') ? 'is-invalid' :'' }}">
					{!! Form::password('password', array('id' => 'password', 'class' => 'mdl-textfield__input', 'required' => 'required' )) !!}
					{!! Form::label('password', Lang::get('auth.password') , array('class' => 'mdl-textfield__label')); !!}
					<span class="mdl-textfield__error">@if ($errors->has('password')){{{ $errors->first('password') }}} <br />@endif</span>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password_confirmation') ? 'is-invalid' :'' }}">
					{!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'mdl-textfield__input', 'required' => 'required' )) !!}
					{!! Form::label('password_confirmation', Lang::get('auth.confirmPassword') , array('class' => 'mdl-textfield__label')); !!}
					<span class="mdl-textfield__error">@if ($errors->has('password_confirmation')){{{ $errors->first('password_confirmation') }}} <br />@endif</span>
				</div>

				{!! Form::button('<span class="mdl-spinner-text">'.Lang::get('auth.resetPassword').'</span><div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner mdl-color-text--white mdl-color-white"></div>', array('class' => 'mdl-button mdl-js-button mdl-js-ripple-effect center mdl-color--primary mdl-color-text--white mdl-button--raised full-span margin-bottom-1 margin-top-2','type' => 'submit','id' => 'submit')) !!}

				{!! Form::close() !!}

			</div>
		</div>
	</main>
</div>



<!-- 	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">{{ Lang::get('titles.resetPword') }}</div>
					<div class="panel-body">

						@if (count($errors) > 0)
							<div class="row">
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-1">
										<div class="alert alert-danger">
											<strong>{{ Lang::get('auth.whoops') }}</strong> {{ Lang::get('auth.someProblems') }}<br><br>
											<ul>
												@foreach ($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									</div>
								</div>
							</div>
						@endif

						{!! Form::open(array('url' => url('/password/reset'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form')) !!}
							{!! csrf_field() !!}
							{!! Form::hidden('token', $token) !!}

							<div class="form-group has-feedback">
								{!! Form::label('email', Lang::get('auth.email') , array('class' => 'col-sm-4 control-label')); !!}
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('email') ? 'is-invalid' :'' }}">
									{!! Form::email('email', old('email'), array('id' => 'email', 'class' => 'form-control', 'placeholder' => Lang::get('auth.ph_email'), 'required' => 'required')) !!}
									<span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>

							<div class="form-group has-feedback">
								{!! Form::label('password', Lang::get('auth.password') , array('class' => 'col-sm-4 control-label')); !!}
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password') ? 'is-invalid' :'' }}">
									{!! Form::password('password', array('id' => 'password', 'class' => 'form-control', 'placeholder' => Lang::get('auth.ph_password'), 'required' => 'required',)) !!}
									<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>

							<div class="form-group has-feedback">
								{!! Form::label('password_confirmation', Lang::get('auth.confirmPassword') , array('class' => 'col-sm-4 control-label')); !!}
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password_confirmation') ? 'is-invalid' :'' }}">
									{!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => Lang::get('auth.ph_password_conf'), 'required' => 'required',)) !!}
									<span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
								</div>
							</div>

							<div class="form-group">
								<div class="mdl-cell mdl-cell--12-col">
									{!! Form::button(Lang::get('auth.resetPassword'), array('class' => 'btn btn-primary','type' => 'submit')) !!}
								</div>
							</div>

						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div> -->
	@endsection


	@section('template_scripts')
	
	@include('scripts.mdl-required-input-fix')
	{!! HTML::script('https://www.google.com/recaptcha/api.js', array('type' => 'text/javascript')) !!}
	@include('scripts.html5-password-match-check')

	<!-- <script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function(event) {
			matching_password_check();
		});
		function matching_password_check() {
			var password = document.getElementById("password");
			var confirm_password = document.getElementById("password_confirmation");
			function validatePassword(){
				if(password.value != confirm_password.value) {
					confirm_password.setCustomValidity("The Passwords do not match");
				} else {
					confirm_password.setCustomValidity('');
				}
			}
			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
		}
	</script> -->
	@endsection