@extends('auth')

@section('template_title')
	Ingresar
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    @include('partials.form-status')

    <div class="mdl-layout mdl-js-layout mdl-color--grey-100 mdl-auth-form">
        <main class="mdl-layout__content">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                    <h2 class="mdl-card__title-text text-center full-span block">

                        {{ Lang::get('titles.app') }}

                    </h2>
                </div>
                <div class="mdl-card__supporting-text">

                    {!! Form::open(array('url' => 'auth/login', 'method' => 'POST', 'class' => '', 'id' => 'login')) !!}

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('email') ? 'is-invalid' :'' }}">
                            {!! Form::email('email', null, array('id' => 'email', 'class' => 'mdl-textfield__input', )) !!}
                            {!! Form::label('email', Lang::get('auth.email') , array('class' => 'mdl-textfield__label')); !!}
                            <span class="mdl-textfield__error"></span>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password') ? 'is-invalid' :'' }}">
                            {!! Form::password('password', array('id' => 'userpass', 'class' => 'mdl-textfield__input')) !!}
                            {!! Form::label('password', Lang::get('auth.password') , array('class' => 'mdl-textfield__label')); !!}
                             <span class="mdl-textfield__error"></span>
                        </div>

                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
                            {!! Form::checkbox('remember', 'remember', null, array('id' => 'remember', 'class' => 'mdl-checkbox__input')); !!}
                            <span class="mdl-checkbox__label">{{ Lang::get('auth.rememberMe') }}</span>
                        </label>

                        {!! Form::button('<span class="mdl-spinner-text">'.Lang::get('auth.login').'</span><div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner mdl-color-text--white mdl-color-white"></div>', array('class' => 'mdl-button mdl-js-button mdl-js-ripple-effect center mdl-color--primary mdl-color-text--white mdl-button--raised full-span margin-bottom-1 margin-top-2','type' => 'submit','id' => 'submit')) !!}

                    {!! Form::close() !!}

                </div>

                <div class="mdl-card__actions mdl-card--border">

                    {!! HTML::link(url('/password/email'), Lang::get('auth.forgot'), array('id' => 'forgot', 'class' => 'mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect left')) !!}
                    {!! HTML::link(url('/register'), Lang::get('auth.register'), array('id' => 'register', 'class' => 'mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect right')) !!}

                </div>
            </div>
        </main>
    </div>

@endsection

@section('template_scripts')
@endsection