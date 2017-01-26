<div class="demo-drawer mdl-layout__drawer mdl-color--cyan-indigo-900 mdl-color-text--cyan-indigo-50">
	<a href="{{ url('/') }}" class="dashboard-logo mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--primary mdl-color-text--white">
		<!-- Laravel
			<i class="material-icons " role="presentation">whatshot</i>
			Material --> {{ Lang::get('titles.app') }}
		</a>
		<header class="demo-drawer-header">
			{{--
			<img src="{{ Gravatar::get(Auth::user()->email) }}" alt="{{ Auth::user()->name }}" class="demo-avatar">
			--}}
			<i class="material-icons mdl-list__item-avatar">face</i>
			<div class="demo-avatar-dropdown">
				<span>
					{{ Auth::user()->name }}
				</span>
				<div class="mdl-layout-spacer"></div>
				@include('partials.account-nav')
			</div>
		</header>

		<nav class="demo-navigation mdl-navigation mdl-color--cyan-indigo-800">

			<a class="mdl-navigation__link" href="{{ url('/') }}" title="{{ Lang::get('titles.app') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons" role="presentation">home</i>
				{{ Lang::get('titles.home') }}
			</a>
			<a class="mdl-navigation__link" href="{{ url('/profile/'.Auth::user()->name) }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons" role="presentation">person</i>
				{{ Lang::get('titles.profile') }}
			</a>
			@if (!Auth::guest() && Auth::user()->hasRole('super administrador') || Auth::user()->hasRole('supervisor') || Auth::user()->hasRole('analista'))
			<a class="mdl-navigation__link" href="{{ route('assignments') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons mdl-badge mdl-badge--overlap" role="presentation">assignment_ind</i>
				Asignación de Analistas
			</a>

			<a class="mdl-navigation__link" href="{{ url('/task') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons mdl-badge mdl-badge--overlap" role="presentation">list</i>
				Actividades
			</a>
			@endif
			<a class="mdl-navigation__link" href="{{ url('/requirement') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons mdl-badge mdl-badge--overlap" role="presentation">receipt</i>
				Requerimientos
			</a>
			@if (!Auth::guest() && Auth::user()->hasRole('super administrador'))

			<a class="mdl-navigation__link" href="{{ url('/users') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons mdl-badge mdl-badge--overlap" data-badge="{{ $totalUsers }}" role="presentation">contacts</i>
				{{ Lang::get('titles.adminUserList') }}
			</a>

			<a class="mdl-navigation__link" href="{{ url('/subject') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons mdl-badge mdl-badge--overlap" role="presentation">subject</i>
				Asuntos
			</a>

<!-- 			<a class="mdl-navigation__link" href="{{ url('/users/create') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons" role="presentation">person_add</i>
				{{ Lang::get('titles.adminNewUser') }}
			</a> -->

			@endif

			<a class="mdl-navigation__link" href="{{ url('/report') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons mdl-badge mdl-badge--overlap" role="presentation">description</i>
				Reportes
			</a>

			@if (!Auth::guest() && \Auth::user()->hasRole('usuario'))
			<a class="mdl-navigation__link" href="{{ route('analysts') }}">
				<i class="mdl-color-text--cyan-indigo-400 material-icons mdl-badge mdl-badge--overlap" role="presentation">contacts</i>
				Analistas
			</a>
			@endif

			<div class="mdl-layout-spacer"></div>

		</nav>
	</div>