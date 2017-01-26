@extends('auth')

@section('template_title')
Reiniciar contraseña
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
					<span class="mdl-textfield__error"></span>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password') ? 'is-invalid' :'' }}">
					{!! Form::password('password', array('id' => 'password', 'class' => 'mdl-textfield__input', 'required' => 'required' )) !!}
					{!! Form::label('password', Lang::get('auth.password') , array('class' => 'mdl-textfield__label')); !!}
					<span class="mdl-textfield__error"></span>
				</div>

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password_confirmation') ? 'is-invalid' :'' }}">
					{!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'mdl-textfield__input', 'required' => 'required' )) !!}
					{!! Form::label('password_confirmation', Lang::get('auth.confirmPassword') , array('class' => 'mdl-textfield__label')); !!}
					<span class="mdl-textfield__error"></span>
				</div>

				{!! Form::button('<span class="mdl-spinner-text">'.Lang::get('auth.resetPassword').'</span><div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner mdl-color-text--white mdl-color-white"></div>', array('class' => 'mdl-button mdl-js-button mdl-js-ripple-effect center mdl-color--primary mdl-color-text--white mdl-button--raised full-span margin-bottom-1 margin-top-2','type' => 'submit','id' => 'submit')) !!}

				{!! Form::close() !!}

			</div>
		</div>
	</main>
</div>
@endsection


@section('template_scripts')

@include('scripts.mdl-required-input-fix')
{!! HTML::script('https://www.google.com/recaptcha/api.js', array('type' => 'text/javascript')) !!}
@include('scripts.html5-password-match-check')

@endsection