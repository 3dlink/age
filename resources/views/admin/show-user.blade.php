@extends('dashboard')

@section('template_title')
	Viendo {{ $user->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('header')
	Viendo {{ $user->name }}
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
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="/users/{{ $user->id }}">
			<span itemprop="name">
				{{ $user->name }}
			</span>
		</a>
		<meta itemprop="position" content="3" />
	</li>
@endsection

@if ($user->hasRole('usuario'))
	@php
        $access_level   = 'Usuario';
        $access_class 	= 'mdl-color--green-200 mdl-color-text--white';
        $access_icon	= 'lock';
	@endphp
@elseif ($user->hasRole('analista'))
	@php
        $access_level   = 'Analista';
        $access_class 	= 'mdl-color--green-400 mdl-color-text--white';
        $access_icon	= 'lock_outline';
	@endphp
@elseif ($user->hasRole('supervisor'))
	@php
        $access_level   = 'Supervisor';
        $access_class 	= 'mdl-color--green-400 mdl-color-text--white';
        $access_icon	= 'lock_outline';
	@endphp
@elseif ($user->hasRole('super administrador'))
	@php
        $access_level   = 'Administrador';
        $access_class 	= 'mdl-color--green-600 mdl-color-text--white';
        $access_icon	= 'verified_user';
	@endphp
@endif

@section('content')

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">

		<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
			<h2 class="mdl-card__title-text">{{$user->name}}'s account</h2>
		</div>
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
					<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--6-col-desktop">
					    <ul class="demo-list-icon mdl-list">
					        <li class="mdl-list__item mdl-typography--font-light">
					        	<div class="mdl-list__item-primary-content">
					        		<i class="material-icons mdl-list__item-icon">{{ $access_icon }}</i>
									{{-- <span class="badge {{ $access_class }}"> --}}
										{{$access_level}}
									{{-- </span> --}}
					        	</div>
					        </li>

							<li class="mdl-list__item mdl-typography--font-light">
								<div class="mdl-list__item-primary-content">
									<i class="material-icons mdl-list__item-icon">event</i>
									Creado: {{ $user->created_at }}
								</div>
							</li>
							<li class="mdl-list__item mdl-typography--font-light">
								<div class="mdl-list__item-primary-content">
									<i class="material-icons mdl-list__item-icon">event</i>
									Actualizado: {{ $user->updated_at }}
								</div>
							</li>

					        <li class="mdl-list__item mdl-typography--font-light">
					        	<div class="mdl-list__item-primary-content">
					        		<i class="material-icons mdl-list__item-icon">person</i>
									<span itemprop="name">
										{{ $user->first_name }} @if ($user->last_name) {{ $user->last_name }} @endif
									</span>
					        	</div>
					        </li>
					        <li class="mdl-list__item mdl-typography--font-light">
					        	<div class="mdl-list__item-primary-content">
					        		<i class="material-icons mdl-list__item-icon">contact_mail</i>
					        		<span itemprop="email">
										{{ $user->email }}
									</span>
					        	</div>
					        </li>
					    </ul>
					</div>
				</div>
		    </div>
		    @if (Auth::user()->id == $user->id)
			    <div class="mdl-card__actions">
					<div class="mdl-grid full-grid">
						<div class="mdl-cell mdl-cell--12-col">
							<a href="{{route('profile.edit', Auth::user()->name)}}" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-shadow--3dp mdl-button--raised mdl-button--primary mdl-color-text--white">
								<i class="material-icons padding-right-half-1">edit</i>
								{{ Lang::get('titles.editProfile') }}
							</a>
						</div>
					</div>
			    </div>
		    @endif
		    <div class="mdl-card__menu">

				<a href="{{ URL::to('users/' . $user->id . '/edit') }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
					<i class="material-icons">edit</i>
				</a>

				{!! Form::open(array('url' => 'users/' . $user->id, 'class' => 'inline-block')) !!}
					{!! Form::hidden('_method', 'DELETE') !!}
					<a href="#" class="dialog-button-delete mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
						<i class="material-icons">delete</i>
					</a>
					<!-- @include('dialogs.dialog-delete') -->
				{!! Form::close() !!}

				<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
					<i class="material-icons">share</i>
				</button>

		    </div>
	    </div>
	</div>
</div>

@endsection

@section('template_scripts')

	<!-- @include('scripts.google-maps-geocode-and-map') -->

	<script type="text/javascript">

		// mdl_dialog('.dialog-button-delete','.dialog-delete-close','#dialog_delete');

	</script>

@endsection