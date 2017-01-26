@extends('dashboard')

@section('template_title')
	Crear Usuario
@endsection

@section('template_fastload_css')
dialog + .backdrop {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0,0,0,0.8);
}
.file_upload_container{
	position: relative;
	width: 100%;
	left: 0;
}
#file_upload_text_div{
	float: left;
}
@endsection

@section('header')
	Crear Usuario
@endsection

@section('content')

@section('breadcrumbs')
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="{{url('/')}}">
			<span itemprop="name">
				{{ Lang::get('titles.app') }}
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="1" />
	</li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="{{ url('/users') }}">
			<span itemprop="name">
				Usuarios
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="2" />
	</li>
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="/users/create">
			<span itemprop="name">
				Crear Usuario
			</span>
		</a>
		<meta itemprop="position" content="3" />
	</li>
@endsection

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">
	    <div class="mdl-card card-new-user" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Crear Usuario</h2>
			</div>

			{!! Form::open(array('action' => 'UsersManagementController@store', 'method' => 'POST', 'role' => 'form', 'files' => 'true')) !!}

				<div class="mdl-card__supporting-text">
					<div class="mdl-grid full-grid padding-0">
						<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

							<div class="mdl-grid ">

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('name') ? 'is-invalid' :'' }}">
										{!! Form::text('name', NULL, array('id' => 'name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z,0-9]*')) !!}
										{!! Form::label('name', Lang::get('auth.name') , array('class' => 'mdl-textfield__label')); !!}
										<span class="mdl-textfield__error">Solo letras y números</span>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('email') ? 'is-invalid' :'' }}">
										{!! Form::email('email', NULL, array('id' => 'email', 'class' => 'mdl-textfield__input')) !!}
										{!! Form::label('email', Lang::get('auth.email') , array('class' => 'mdl-textfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
							        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('first_name') ? 'is-invalid' :'' }}">
							            {!! Form::text('first_name', NULL, array('id' => 'first_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
							            {!! Form::label('first_name', 'Nombre', array('class' => 'mdl-textfield__label')); !!}
							            <span class="mdl-textfield__error">Solo letras</span>
							        </div>
							  	</div>
							  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('last_name') ? 'is-invalid' :'' }}">
								        {!! Form::text('last_name', NULL, array('id' => 'last_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
								        {!! Form::label('last_name', 'Apellido', array('class' => 'mdl-textfield__label')); !!}
								        <span class="mdl-textfield__error">Solo letras</span>
								    </div>
							  	</div>
							  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('phone') ? 'is-invalid' :'' }}">
								        {!! Form::text('phone', NULL, array('id' => 'phone', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('phone', 'Número telefónico', array('class' => 'mdl-textfield__label')); !!}
								    </div>
							  	</div>
							  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('skype_user') ? 'is-invalid' :'' }}">
								        {!! Form::text('skype_user', NULL, array('id' => 'skype_user', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('skype_user', 'Usuario de skype', array('class' => 'mdl-textfield__label')); !!} 
								    </div>
							  	</div>

							  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="file_upload_container">
									    <div id="file_upload_text_div" class="mdl-textfield mdl-js-textfield">
											<input class="file_upload_text mdl-textfield__input mdl-color-text--white mdl-file-input" type="text" disabled readonly id="file_upload_text"/>
											<label class="mdl-textfield__label profile_pic_label" for="file_upload_text">Imagen de perfil</label>
									    </div>
									    <div class="file_upload_btn">
									     	<label class="image_input_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-color-text--white">
									        	<i class="material-icons">wallpaper</i>

									       		{!! Form::file('user_profile_pic',  array('id' => 'file_upload_btn', 'class' => 'hidden mdl-file-input', 'accept'=> "image/*" )) !!}
									      	</label>
									    </div>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('user_level') ? 'is-invalid' :'' }}">
										{!! Form::select('user_level', array('' => '', '4' => 'Usuario', '3' => 'Analista', '2' => 'Supervisor', '1' => 'Administrador'), NULL, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'user_level')) !!}
									    <label for="user_level">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('user_level', Lang::get('forms.label-userrole_id'), array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password') ? 'is-invalid' :'' }}">
								        {!! Form::password('password', array('id' => 'password', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('password', 'Contraseña', array('class' => 'mdl-textfield__label')); !!}
								    	<span class="mdl-textfield__error"></span>
								    </div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('password_confirmation') ? 'is-invalid' :'' }}">
								        {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('password_confirmation', 'Confirmar contraseña', array('class' => 'mdl-textfield__label')); !!}
								    	<span class="mdl-textfield__error"></span>
								    </div>
								</div>

								<div class="mdl-cell mdl-cell--12-col">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('bio') ? 'is-invalid' :'' }}">
								        {!! Form::textarea('bio',  NULL, array('id' => 'bio', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('bio', 'Biografía', array('class' => 'mdl-textfield__label')); !!}
								    </div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="mdl-card__actions padding-top-0">
					<div class="mdl-grid padding-top-0">
						<div class="mdl-cell mdl-cell--12-col padding-top-0 margin-top-0 margin-left-1-1">

							{{-- SAVE BUTTON--}}
							<span class="save-actions">
								{!! Form::button('<i class="material-icons">save</i> Crear Usuario', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
							</span>

						</div>
					</div>
				</div>

			    <div class="mdl-card__menu mdl-color-text--white">

					{{-- SAVE ICON --}}
					<span class="save-actions">
						{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-button-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'Crear usuario')) !!}
					</span>
			    </div>

			    <!-- @include('dialogs.dialog-save') -->

		    {!! Form::close() !!}

	    </div>
	</div>
</div>

@endsection

@section('template_scripts')

	@include('scripts.mdl-required-input-fix')
	@include('scripts.mdl-file-upload')
	@include('scripts.html5-password-match-check')

	<script type="text/javascript">
		mdl_dialog('.dialog-button-save');
		mdl_dialog('.dialog-button-icon-save');

		var dialog = document.querySelector('#dialog');
		dialogPolyfill.registerDialog(dialog);

		$('.dialog-close').click(function(){
			$('.backdrop').css("z-index", -100001);
		});

		$('.dialog-button-icon-save').click(function(){
			$('.backdrop').css("z-index", 100001);
		});

		$('#submit').click(function(event) {
			$('form').submit();
		});
	</script>

@endsection

@section('dialog_section')
	@include('dialogs.dialog-save')
	<div class="backdrop" style="z-index: -100001;"></div>
@endsection