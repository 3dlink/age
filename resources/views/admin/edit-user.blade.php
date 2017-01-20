@extends('dashboard')

@section('template_title')
	Editing User {{ $user->name }}
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
@endsection

@section('header')
	Editing {{ $user->name }}
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
				Users List
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="2" />
	</li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="{{ route('users.show', $user->id) }}">
			<span itemprop="name">
				{{ $user->name }}
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="3" />
	</li>
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="/users/{{ $user->id }}/edit">
			<span itemprop="name">
				Editing
			</span>
		</a>
		<meta itemprop="position" content="4" />
	</li>

@endsection

@section('content')

	<div class="mdl-grid full-grid margin-top-0 padding-0">
		<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">

			{!! Form::model($user, array('action' => array('UsersManagementController@update', $user->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}

				<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">
					<div class="mdl-user-avatar">
						<img src="{{ Gravatar::get($user->email) }}" alt="{{ $user->name }}">
						<span itemprop="image" style="display:none;">{{ Gravatar::get($user->email) }}</span>
					</div>

					<div class="mdl-card__title" @if ($user->profile->user_profile_bg != NULL) style="background: url('{{$user->profile->user_profile_bg}}') center/cover;" @endif>

<!-- 						<div class="file_upload_container">
						    <div class="file_upload_btn">
						     	<label class="image_input_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-color-text--white">
						        	<i class="material-icons">wallpaper</i>

						       		{!! Form::file('user_profile_bg',  array('id' => 'file_upload_btn', 'class' => 'hidden mdl-file-input')) !!}
						      	</label>
						    </div>
						    <div id="file_upload_text_div" class="mdl-textfield mdl-js-textfield">
								<input class="file_upload_text mdl-textfield__input mdl-color-text--white mdl-file-input" type="text" disabled readonly id="file_upload_text" />
								<label class="mdl-textfield__label sr-only" for="file_upload_text">Change Profile Background Image</label>
						    </div>
						</div> -->

						<h3 class="mdl-card__title-text mdl-title-username">
							{{ $user->name }}
						</h3>
					</div>
					<div class="mdl-card__supporting-text">
						<div class="mdl-grid full-grid padding-0">
							<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--6-col-desktop">

								<div class="mdl-grid ">

									<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('name') ? 'is-invalid' :'' }}">
											{!! Form::text('name', $user->name, array('id' => 'name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z,0-9]*')) !!}
											{!! Form::label('name', Lang::get('auth.name') , array('class' => 'mdl-textfield__label')); !!}
											<span class="mdl-textfield__error">Letters and numbers only</span>
										</div>
									</div>

									<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('user_level') ? 'is-invalid' :'' }}">
											{!! Form::select('user_level', array('4' => 'User', '3' => 'Analist', '2' => 'Supervisor', '1' => 'Administrator'), $user->role->id, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'user_level')) !!}
										    <label for="user_level">
										        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
										    </label>
											{!! Form::label('user_level', Lang::get('forms.label-userrole_id'), array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
											<span class="mdl-textfield__error">Select user access level</span>
										</div>
									</div>

									<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('email') ? 'is-invalid' :'' }}">
											{!! Form::email('email', $user->email, array('id' => 'email', 'class' => 'mdl-textfield__input')) !!}
											{!! Form::label('email', Lang::get('auth.email') , array('class' => 'mdl-textfield__label')); !!}
											<span class="mdl-textfield__error">Please Enter a Valid {{ Lang::get('auth.email') }}</span>
										</div>
									</div>
									<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('first_name') ? 'is-invalid' :'' }}">
								            {!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
								            {!! Form::label('first_name', Lang::get('auth.first_name') , array('class' => 'mdl-textfield__label')); !!}
								            <span class="mdl-textfield__error">Letters only</span>
								        </div>
								  	</div>
								  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('last_name') ? 'is-invalid' :'' }}">
									        {!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'mdl-textfield__input', 'pattern' => '[A-Z,a-z]*')) !!}
									        {!! Form::label('last_name', Lang::get('auth.last_name') , array('class' => 'mdl-textfield__label')); !!}
									        <span class="mdl-textfield__error">Letters only</span>
									    </div>
								  	</div>
								</div>
							</div>


							<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--6-col-desktop">

								<div class="mdl-grid ">
<!-- 									<div class="mdl-cell mdl-cell--12-col">

										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label margin-bottom-1 {{ $errors->has('location') ? 'is-invalid' :'' }}">
										    {!! Form::text('location', $user->profile->location, array('id' => 'location', 'class' => 'mdl-textfield__input' )) !!}
										    {!! Form::label('location', Lang::get('profile.label-location') , array('class' => 'mdl-textfield__label')); !!}
											<span class="mdl-textfield__error">Please Enter a Valid Location</span>

										</div>
										@if ($user->profile->location)
											<div class="card-image mdl-card mdl-shadow--2dp">
												<div id="map-canvas"></div>
												<div class="mdl-card__actions mdl-color--primary mdl-color-text--white">
													<p class="mdl-typography--font-light">
														LON: <span id="longitude"></span> / LAT: <span id="latitude"></span>
													</p>
												</div>
											</div>
										@endif

									</div> -->
								</div>
							</div>
						</div>
					</div>

				    <div class="mdl-card__actions padding-top-0">
						<div class="mdl-grid padding-top-0">
							<div class="mdl-cell mdl-cell--12-col padding-top-0 margin-top-0 margin-left-1-1">

								{{-- SAVE BUTTON--}}
								<span class="save-actions">
									{!! Form::button('<i class="material-icons">save</i> <span class="hide-mobile">Save</span> <span class="hide-tablet">Changes</span>', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
								</span>

								{{-- ADMIN VIEW USER BUTTON --}}
								<a href="{{ URL::to('users/' . $user->id) }}" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-color--primary mdl-color-text--white margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 " title="view profile">
									<i class="material-icons">account_circle</i> <span class="hide-mobile hide-tablet">View</span> <span class="hide-mobile hide-tablet">User</span> <span class="hide-mobile">Account</span>
								</a>

								{{-- VIEW PROFILE BUTTON --}}
								<a href="{{ route('profile.show', Auth::user()->name) }}" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-color--blue-600 mdl-color-text--white margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 " title="view profile">
									<i class="material-icons">person_outline</i> <span class="hide-mobile hide-tablet">View</span> <span class="hide-mobile hide-tablet">User</span> <span class="hide-mobile">Profile</span>
								</a>

								{{-- DELETE USER BUTTON--}}
<!-- 								{!! Form::button('<i class="material-icons">delete</i> <span class="hide-mobile">Delete</span> <span class="hide-mobile hide-tablet">User</span>', array('class' => 'dialog-button-delete mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--red mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop padding-left-1 padding-right-1 ')) !!} -->

							</div>
						</div>
				    </div>

				    <div class="mdl-card__menu">

						{{-- SAVE ICON --}}
						<span class="save-actions">
							{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-button-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'Save Changes')) !!}
						</span>

<!-- 						{{-- DELETE USER ICON --}}
						<a href="#" class="dialog-button-delete-icon dialiog-trigger-delete dialiog-trigger{{$user->id}} mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" data-userid="{{$user->id}}" title="Delete User">
							<i class="material-icons">delete</i>
						</a> -->

						{{-- VIEW PROFILE ICON --}}
						<a href="/profile/{{Auth::user()->name}}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="View User Profile">
							<i class="material-icons">person_outline</i>
						</a>

						{{-- VIEW ACCOUNT ICON --}}
						<a href="/users/{{$user->id}}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="View User Account">
							<i class="material-icons">account_circle</i>
						</a>
				    </div>

				</div>

				@include('dialogs.dialog-save')

			{!! Form::close() !!}

			{!! Form::open(array('url' => 'users/' . $user->id, 'class' => 'inline-block', 'id' => 'delete_'.$user->id)) !!}
				{!! Form::hidden('_method', 'DELETE') !!}
				@include('dialogs.dialog-delete')
			{!! Form::close() !!}

		</div>
	</div>

@endsection

@section('template_scripts')

	@include('scripts.mdl-required-input-fix')<!-- 
	@include('scripts.gmaps-address-lookup-api3')
	@include('scripts.google-maps-geocode-and-map') -->
	@include('scripts.mdl-select')
	<!-- @include('scripts.mdl-file-upload') -->

	<script type="text/javascript">

		mdl_dialog('.dialog-button-save');
		mdl_dialog('.dialog-button-icon-save');
		mdl_dialog('.dialog-button-delete','.dialog-delete-close','#dialog_delete');
		mdl_dialog('.dialog-button-delete-icon','.dialog-delete-close','#dialog_delete');

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

		// $('form input, form select, form textarea').on('input', function() {
		//     $('.save-actions').show();
		// });

		// $('.mdl-select-input, .mdl-file-input').change(function(event) {
		// 	$('.save-actions').show();
		// });

	</script>

@endsection

@section('dialog_section')
	<!-- @include('dialogs.dialog-save') -->
	<div class="backdrop" style="z-index: -100001;"></div>
@endsection