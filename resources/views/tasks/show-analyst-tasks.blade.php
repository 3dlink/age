@extends('dashboard')

@section('template_title')
Actividades
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
.rd-container-attachment{
z-index: 1;
}
rd-time-list{
border: solid !important;
}
@endsection

@section('header')
Motrando las Actividades de {{$user->first_name.' '.$user->last_name}}
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
	<a itemprop="item" href="{{ route('analysts') }}">
		<span itemprop="name">
			Analistas
		</span>
	</a>
	<i class="material-icons">chevron_right</i>
	<meta itemprop="position" content="1" />
</li>
<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="{{ route('task.index') }}" disabled>
		<span itemprop="name">
			Actividades
		</span>
	</a>
	<meta itemprop="position" content="2" />
</li>
@endsection

@section('content')

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell--12-col">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('paginator') ? 'is-invalid' :'' }}">
			{!! Form::text('paginator', NULL, array('id' => 'paginator', 'class' => 'mdl-textfield__input')) !!}
			{!! Form::label('paginator', 'Elija la semana que desea ver', array('class' => 'mdl-textfield__label')); !!}
		</div>
	</div>
</div>

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
	<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
		<h2 class="mdl-card__title-text logo-style mdl-cell--4-col">
			@if ($tasksN->count() === 1)
			{{ $tasksN->count() }} Actividad en horario regular
			@elseif ($tasksN->count() > 1)
			{{ $tasksN->count() }} Actividades en horario regular
			@else
			Sin Actividades :(
			@endif
		</h2>

		<span class="mdl-cell--2-col">Total: {{$cantN}}/50</span>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="mdl-data-table mdl-js-data-table data-table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Analista</th>
						<th class="mdl-data-table__cell--non-numeric">Cliente</th>
						<th class="mdl-data-table__cell--non-numeric">Fecha</th>
						<th class="mdl-data-table__cell--non-numeric">Hona de Inicio</th>
						<th class="mdl-data-table__cell--non-numeric">Duración</th>
						<!-- <th class="mdl-data-table__cell--non-numeric">Description</th> -->
						<th class="mdl-data-table__cell--non-numeric">Tipo</th>
						<th class="mdl-data-table__cell--non-numeric no-sort no-search">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tasksN as $a_task)
					<tr>
						<td class="mdl-data-table__cell--non-numeric">{{$a_task->user->first_name.' '.$a_task->user->last_name}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{$a_task->client->first_name.' '.$a_task->client->last_name}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{date('d/m/Y', strtotime($a_task->fecha))}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{date('H:i', strtotime($a_task->hora_inicio))}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{$a_task->cant_horas/60}}</td>
						<!-- <td class="mdl-data-table__cell--non-numeric">{{$a_task->descripcion}}</td> -->
						<td class="mdl-data-table__cell--non-numeric">
							@if($a_task->tipo == 1)
							Presencial
							@elseif($a_task->tipo == 2)
							Distancia
							@endif
						</td>

						<td class="mdl-data-table__cell--non-numeric">
							{{-- SHOW TASK ICON BUTTON --}}
							<a href="{{ url('analyst/task/'.$year.'/'.$week.'/'.$a_task->id) }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Ver detalle">
								<i class="material-icons">visibility</i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="mdl-card__menu" style="top: -5px;">
		<a href="{{ url('analyst/pdf/'.$user->name.'/'.$year.'/'.$week) }}" class="mdl-button mdl-button--icon mdl-inline-expanded mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-color-text--white inline-block" style="vertical-align: middle;" title="Descargar Servicio Nominal">
			<i class="material-icons">get_app</i>
		</a>
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
@if(!count($tasksE) == 0)
<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
	<div class="mdl-card__title mdl-color--red mdl-color-text--white">
		<h2 class="mdl-card__title-text logo-style mdl-cell--4-col">
			@if ($tasksE->count() === 1)
			{{ $tasksE->count() }} Actividad en horas extra
			@elseif ($tasksE->count() > 1)
			{{ $tasksE->count() }} Actividades en horas extra
			@else
			Sin Actividades :(
			@endif
		</h2>
		<span class="mdl-cell--2-col">Total: {{$cantE}}</span>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="mdl-data-table mdl-js-data-table data-table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Analista</th>
						<th class="mdl-data-table__cell--non-numeric">Cliente</th>
						<th class="mdl-data-table__cell--non-numeric">Fecha</th>
						<th class="mdl-data-table__cell--non-numeric">Hora de inicio</th>
						<th class="mdl-data-table__cell--non-numeric">Duración</th>
						<!-- <th class="mdl-data-table__cell--non-numeric">Description</th> -->
						<th class="mdl-data-table__cell--non-numeric">Tipo</th>
						<th class="mdl-data-table__cell--non-numeric no-sort no-search">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tasksE as $a_task)
					<tr>
						<td class="mdl-data-table__cell--non-numeric">{{$a_task->user->first_name.' '.$a_task->user->last_name}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{$a_task->client->first_name.' '.$a_task->client->last_name}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{date('d/m/Y', strtotime($a_task->fecha))}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{date('H:i', strtotime($a_task->hora_inicio))}}</td>
						<td class="mdl-data-table__cell--non-numeric">{{$a_task->cant_horas/60}}</td>
						<!-- <td class="mdl-data-table__cell--non-numeric">{{$a_task->descripcion}}</td> -->
						<td class="mdl-data-table__cell--non-numeric">
							@if($a_task->tipo == 1)
							Presencial
							@elseif($a_task->tipo == 2)
							Distancia
							@endif
						</td>
						<td class="mdl-data-table__cell--non-numeric">
							{{-- SHOW TASK ICON BUTTON --}}
							<a href="{{ url('analyst/task/'.$year.'/'.$week.'/'.$a_task->id) }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Ver detalle">
								<i class="material-icons">visibility</i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="mdl-card__menu" style="top: -5px;">
		<a href="{{ url('analyst/pdf/'.$user->name.'/'.$year.'/'.$week) }}" class="mdl-button mdl-button--icon mdl-inline-expanded mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-color-text--white inline-block" style="vertical-align: middle;" title="Descargar Servicio Nominal">
			<i class="material-icons">get_app</i>
		</a>
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
@endif

@endsection

@section('template_scripts')

@include('scripts.mdl-datatables')

<script type="text/javascript">
	let paginator = document.getElementById('paginator');

	let initial = moment().isoWeek({{$week}}).day('Monday');

	let weekpicker = rome(paginator, {
		time:false,
		weekStart: 1,
		initialValue: initial,
		dateValidator: date => {
			return moment(date).day() == 1;
		}
	});
	weekpicker.on('data', date => {
		let url = "{!! url('analyst/'.$user->name) !!}";
		url += '/';
		url += moment(date).year();
		url += '/';
		url += moment(date).isoWeek();

		if (moment(date).isoWeek() != moment(initial).isoWeek()) {
			window.location.replace(url);
		}
	});

</script>

@endsection
