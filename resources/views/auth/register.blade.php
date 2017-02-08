@extends('auth')

@section('template_title')
	Registrar
@endsection


@section('template_fastload_css')
@endsection


@section('content')

	@include('partials.form-status')

    <div class="mdl-layout mdl-js-layout mdl-color--grey-100">
        <main class="mdl-layout__content margin-top-3-tablet">
			<div class="mdl-grid mdl-grid--no-spacing">
			  	<div class="mdl-cell--6-col-tablet mdl-cell--1-offset-tablet mdl-cell--6-col-desktop mdl-cell--3-offset-desktop ">

			       	<div class="demo-card-full mdl-card mdl-shadow--2dp">

			                <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
			                    <h2 class="mdl-card__title-text text-center full-span block">

			                        {{ Lang::get('titles.register') }}

			                    </h2>
			                </div>
			                <div class="mdl-card__supporting-text ">

								{!! Form::open(array('url' => url('/auth/register'), 'method' => 'POST', 'class' => '', 'role' => 'form', 'id' => 'register')) !!}

									<div class="mdl-grid ">
									  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('name') ? 'is-invalid' :'' }}">
											    {!! Form::text('name', old('name'), array('id' => 'name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z,0-9]*')) !!}
											    {!! Form::label('name', Lang::get('auth.name') , array('class' => 'mdl-textfield__label')); !!}
											    <span class="mdl-textfield__error">Solo letras y números</span>
											</div>
									  	</div>

									  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('empresa') ? 'is-invalid' :'' }}">
											    {!! Form::text('empresa', old('empresa'), array('id' => 'empresa', 'class' => 'mdl-textfield__input')) !!}
											    {!! Form::label('empresa', 'Empresa' , array('class' => 'mdl-textfield__label')); !!}
											    <span class="mdl-textfield__error"></span>
											</div>
									  	</div>

									  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('email') ? 'is-invalid' :'' }}">
									            {!! Form::email('email', null, array('id' => 'email', 'class' => 'mdl-textfield__input' )) !!}
									            {!! Form::label('email', Lang::get('auth.email') , array('class' => 'mdl-textfield__label')); !!}
									            <span class="mdl-textfield__error">Ingrese un correo válido {{ Lang::get('auth.email') }}</span>
									        </div>
									  	</div>
										<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('first_name') ? 'is-invalid' :'' }}">
									            {!! Form::text('first_name', old('first_name'), array('id' => 'first_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
									            {!! Form::label('first_name', Lang::get('auth.first_name') , array('class' => 'mdl-textfield__label')); !!}
									            <span class="mdl-textfield__error">Solo letras</span>
									        </div>
									  	</div>
									  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
										    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('last_name') ? 'is-invalid' :'' }}">
										        {!! Form::text('last_name', old('last_name'), array('id' => 'last_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
										        {!! Form::label('last_name', Lang::get('auth.last_name') , array('class' => 'mdl-textfield__label')); !!}
										        <span class="mdl-textfield__error">Solo letras</span>
										    </div>
									  	</div>
									  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password') ? 'is-invalid' :'' }}">
									            {!! Form::password('password', array('id' => 'password', 'class' => 'mdl-textfield__input', 'required' => 'required' )) !!}
									            {!! Form::label('password', Lang::get('auth.password') , array('class' => 'mdl-textfield__label')); !!}
									            <span class="mdl-textfield__error"></span>
									        </div>
									  	</div>
									  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password_confirmation') ? 'is-invalid' :'' }}">
									            {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'mdl-textfield__input', 'required' => 'required' )) !!}
									            {!! Form::label('password_confirmation', Lang::get('auth.confirmPassword') , array('class' => 'mdl-textfield__label')); !!}
									            <span class="mdl-textfield__error"></span>
									        </div>
									  	</div>

									  	<div class="mdl-cell mdl-cell--12-col">
											{!! Form::button('<span class="mdl-spinner-text">'.Lang::get('auth.register').'</span><div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner mdl-color-text--white mdl-color-white"></div>', array('class' => 'mdl-button mdl-js-button mdl-js-ripple-effect center mdl-color--primary mdl-color-text--white mdl-button--raised full-span margin-bottom-1 margin-top-2','type' => 'submit','id' => 'submit')) !!}
									  	</div>
									</div>

								{!! Form::close() !!}

			                </div>

			                <div class="mdl-card__actions mdl-card--border">

			                    {!! HTML::link(url('/password/email'), Lang::get('auth.forgot'), array('id' => 'forgot', 'class' => 'mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect left')) !!}
			                  	{!! HTML::link(url('/login'), Lang::get('auth.login'), array('id' => 'login', 'class' => 'mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect right')) !!}

			                </div>
			        </div>

			  	</div>
			</div>
        </main>
    </div>

@endsection

@section('template_scripts')

	@include('scripts.mdl-required-input-fix')
	<!-- {!! HTML::script('https://www.google.com/recaptcha/api.js', array('type' => 'text/javascript')) !!} -->
	@include('scripts.html5-password-match-check')


@endsection