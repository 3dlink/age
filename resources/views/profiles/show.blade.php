@extends('dashboard')

@section('template_title')
	Perfil de {{ $user->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('header')
	<small>
		{{ Lang::get('profile.showProfileTitle',['username' => $user->name]) }}
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

	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="#" disabled>
			<span itemprop="name">
				Perfil
			</span>
		</a>
		<meta itemprop="position" content="2" />
	</li>

@endsection

@section('content')

	@include('cards.user-profile-card')

@endsection

@section('template_scripts')

	<!-- @include('scripts.google-maps-geocode-and-map') -->

@endsection