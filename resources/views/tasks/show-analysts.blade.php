@extends('dashboard')

@section('template_title')
	Mostrando Analistas
@endsection

@section('template_linked_css')
	{!! HTML::style(asset('https://cdn.datatables.net/1.10.12/css/dataTables.material.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
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
	Mostrando Todos los Analistas
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
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="#" disabled>
			<span itemprop="name">
				Analistas
			</span>
		</a>
		<meta itemprop="position" content="2" />
	</li>
@endsection

@section('content')

<?php 
	$date = date ('Y-m-d', strtotime('monday this week'));
?>

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
	<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
		<h2 class="mdl-card__title-text logo-style">
			@if ($total_users === 1)
			    {{ $total_users }} Analista en Total
			@elseif ($total_users > 1)
			    {{ $total_users }} Analistas en Total
			@else
			    Sin Analistas :(
			@endif
		</h2>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="mdl-data-table mdl-js-data-table data-table" cellspacing="0" width="100%">
			  <thead>
			    <tr>
					<th class="mdl-data-table__cell--non-numeric">Nombre</th>
					<th class="mdl-data-table__cell--non-numeric">Correo Electrónico</th>
					<th class="mdl-data-table__cell--non-numeric">Teléfono</th>
					<th class="mdl-data-table__cell--non-numeric">Skype</th>
					<th class="mdl-data-table__cell--non-numeric no-sort no-search">Acciones</th>
			    </tr>
			  </thead>
			  <tbody>
			        @foreach ($users as $a_user)
						<tr>
							<td class="mdl-data-table__cell--non-numeric">{{$a_user->first_name.' '.$a_user->last_name}}</td>
							<td class="mdl-data-table__cell--non-numeric">{{$a_user->email}}</td>
							<td class="mdl-data-table__cell--non-numeric">{{$a_user->profile->phone}}</td>
							<td class="mdl-data-table__cell--non-numeric">{{$a_user->profile->skype_user}}</td>
							<td class="mdl-data-table__cell--non-numeric">
							@if($user->hasRole('usuario'))
							@if($a_user->hasRole('analista') || $a_user->hasRole('supervisor'))
								{{-- VIEW TASK ICON BUTTON --}}
								<a href="{{ url('/analyst/'.$a_user->name.'/'.date('Y', strtotime($date)).'/'.date('W', strtotime($date))) }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Ver Actividades">
									<i class="material-icons">list</i>
								</a>
							@endif
							@endif
							</td>
						</tr>
			        @endforeach
			  </tbody>
			</table>
		</div>
	</div>
    <div class="mdl-card__menu" style="top: -5px;">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable search-white"  style="vertical-align: middle;padding: 17px 0;">
			<label class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect mdl-button--icon" for="search_table">
			  	<i class="material-icons">search</i>
			</label>
			<div class="mdl-textfield__expandable-holder">
			  	<input class="mdl-textfield__input" type="search" id="search_table" placeholder="Buscar">
			  	<label class="mdl-textfield__label" for="search_table">
			  		Buscar
			  	</label>
			</div>
		</div>
    </div>
</div>

@endsection

@section('template_scripts')

	@include('scripts.mdl-datatables')

@endsection