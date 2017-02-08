@extends('dashboard')

@section('template_title')
Editar su perfil
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
<small>
	{{ Lang::get('profile.editProfileTitle') }} | {{ Lang::get('profile.showProfileTitle',['username' => $user->name]) }}
</small>
@endsection

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

<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="{{ url('/profile/'.Auth::user()->name) }}">
		<span itemprop="name">
			{{ Lang::get('titles.profile') }}
		</span>
	</a>
	<i class="material-icons">chevron_right</i>
	<meta itemprop="position" content="2" />
</li>
<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="#" disabled>
		<span itemprop="name">
			Editar perfil
		</span>
	</a>
	<meta itemprop="position" content="2" />
</li>

@endsection

@section('content')

@if (Auth::user()->id == $user->id)

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">

		<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
			<h2 class="mdl-card__title-text">Editando perfil de {{$user->first_name.' '.$user->last_name}}</h2>
		</div>

		{!! Form::model($user->profile, ['method' => 'PATCH', 'route' => ['profile.update', $user->name],  'class' => '', 'role' => 'form', 'enctype' => 'multipart/form-data' ]) !!}
		<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-user-avatar">
				@if($user->profile->profile_pic != NULL)
				<img src="{{ url($user->profile->profile_pic) }}" alt="{{ $user->name }}">
				@else
				<img src="{{ Gravatar::get($user->email) }}" alt="{{ $user->name }}">
				@endif
				<span itemprop="image" style="display:none;">{{ Gravatar::get($user->email) }}</span>
			</div>

			<div class="mdl-card__title" @if ($user->profile->user_profile_bg != NULL) style="background: url('{{$user->profile->user_profile_bg}}') center/cover;" @endif>

				<h3 class="mdl-card__title-text mdl-title-username">
					{{ $user->name }}
				</h3>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid full-grid padding-0">
					<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

						<div class="mdl-grid ">

							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('empresa') ? 'is-invalid' :'' }}">
									{!! Form::text('empresa', $user->empresa, array('id' => 'empresa', 'class' => 'mdl-textfield__input', 'disabled')) !!}
									{!! Form::label('empresa', 'Empresa' , array('class' => 'mdl-textfield__label')); !!}
									<span class="mdl-textfield__error"></span>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('name') ? 'is-invalid' :'' }}">
									{!! Form::text('name', $user->name, array('id' => 'name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z,0-9]*', 'disabled')) !!}
									{!! Form::label('name', Lang::get('auth.name') , array('class' => 'mdl-textfield__label')); !!}
									<span class="mdl-textfield__error">Solo letras y números</span>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('email') ? 'is-invalid' :'' }}">
									{!! Form::email('email', $user->email, array('id' => 'email', 'class' => 'mdl-textfield__input', 'disabled')) !!}
									{!! Form::label('email', Lang::get('auth.email') , array('class' => 'mdl-textfield__label')); !!}
									<span class="mdl-textfield__error"></span>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('first_name') ? 'is-invalid' :'' }}">
									{!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
									{!! Form::label('first_name', Lang::get('auth.first_name') , array('class' => 'mdl-textfield__label')); !!}
									<span class="mdl-textfield__error">Solo letras</span>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('last_name') ? 'is-invalid' :'' }}">
									{!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
									{!! Form::label('last_name', Lang::get('auth.last_name') , array('class' => 'mdl-textfield__label')); !!}
									<span class="mdl-textfield__error">Solo letras</span>
								</div>
							</div>

							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('phone') ? 'is-invalid' :'' }}">
									{!! Form::text('phone', $user->profile->phone, array('id' => 'phone', 'class' => 'mdl-textfield__input')) !!}
									{!! Form::label('phone', 'Número telefónico' , array('class' => 'mdl-textfield__label')); !!}
								</div>
							</div>

							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('skype_user') ? 'is-invalid' :'' }}">
									{!! Form::text('skype_user', $user->profile->skype_user, array('id' => 'skype_user', 'class' => 'mdl-textfield__input')) !!}
									{!! Form::label('skype_user', 'Usuario de skype' , array('class' => 'mdl-textfield__label')); !!}
								</div>
							</div>

							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="file_upload_container">
									<div id="file_upload_text_div" class="mdl-textfield mdl-js-textfield">
										<input class="file_upload_text mdl-textfield__input mdl-color-text--white mdl-file-input" type="text" disabled readonly id="file_upload_text" accept="image/*"/>
										<label class="mdl-textfield__label profile_pic_label" for="file_upload_text">Imagen de perfil</label>
									</div>
									<div class="file_upload_btn">
										<label class="image_input_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-color-text--white">
											<i class="material-icons">add_a_photo</i>

											{!! Form::file('user_profile_pic',  array('id' => 'file_upload_btn', 'class' => 'hidden mdl-file-input', 'accept'=> "image/*" )) !!}
										</label>
									</div>
								</div>
							</div>

							<div class="mdl-cell mdl-cell--12-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('bio') ? 'is-invalid' :'' }}">
									{!! Form::textarea('bio',  $user->profile->bio, array('id' => 'bio', 'class' => 'mdl-textfield__input')) !!}
									{!! Form::label('bio', Lang::get('profile.label-bio') , array('class' => 'mdl-textfield__label')); !!}
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="mdl-card__actions padding-top-0">
				<div class="mdl-grid padding-top-0">
					<div class="mdl-cell mdl-cell--12-col padding-top-0 margin-top-0">
						<span class="save-actions">
							{!! Form::button('<i class="material-icons">save</i> <span class="hide-mobile">Guardar</span> <span class="hide-tablet">Cambios</span>', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
						</span>
					</div>
				</div>
			</div>
			<div class="mdl-card__menu">
				<span class="save-actions start-hidden">
					{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'ver perfil')) !!}
				</span>
				<a href="/profile/{{Auth::user()->name}}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="view profile">
					<i class="material-icons">person_outline</i>
				</a>
			</div>
		</div>

		@include('dialogs.dialog-save')

		{!! Form::close() !!}

	</div>
</div>

@else
<p>{{ Lang::get('profile.notYourProfile') }}</p>
@endif

@endsection

@section('template_scripts')

@include('scripts.mdl-required-input-fix')
@include('scripts.mdl-file-upload')

<script type="text/javascript">

	mdl_dialog('.dialog-button-save');
	mdl_dialog('.dialog-button-icon-save');

		// $('form input, form select, form textarea').on('input', function() {
		//     $('.save-actions').show();
		// });

		// $('.mdl-select-input, .mdl-file-input').change(function(event) {
		// 	$('.save-actions').show();
		// });

		var dialog = document.querySelector('#dialog');
		dialogPolyfill.registerDialog(dialog);

		$('.dialog-close').click(function(){
			$('.backdrop').css("z-index", -100001);
		});

		$('.dialog-button-icon-save').click(function(){
			$('.backdrop').css("z-index", 1000001);
		});

		$('#submit').click(function(event) {
			$('form').submit();
		});

	</script>

	@endsection

	@section('dialog_section')
	<!-- @include('dialogs.dialog-save') -->
	<div class="backdrop" style="z-index: -100001;"></div>
	@endsection