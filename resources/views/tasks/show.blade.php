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
@endsection

@section('header')
Mostrando Todas las Actividades
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
	<a itemprop="item" href="{{ route('task.index') }}" disabled>
		<span itemprop="name">
			Actividades
		</span>
	</a>
	<meta itemprop="position" content="2" />
</li>
@endsection

@section('content')

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
	<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
		<h2 class="mdl-card__title-text logo-style">
			@if ($total_tasks === 1)
			{{ $total_tasks }} Actividad en Total
			@elseif ($total_tasks > 1)
			{{ $total_tasks }} Actividades en Total
			@else
			Sin Actividades :(
			@endif
		</h2>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="mdl-data-table mdl-js-data-table data-table" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Analista</th>
						<th class="mdl-data-table__cell--non-numeric">Cliente</th>
						<th class="mdl-data-table__cell--non-numeric">Fecha</th>
						<th class="mdl-data-table__cell--non-numeric">Hora de Inicio</th>
						<th class="mdl-data-table__cell--non-numeric">Duración</th>
						<!-- <th class="mdl-data-table__cell--non-numeric">Description</th> -->
						<th class="mdl-data-table__cell--non-numeric">Tipo</th>
						@if(!\Auth::user()->hasRole('usuario'))
						<th class="mdl-data-table__cell--non-numeric no-sort no-search">Acciones</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($tasks as $a_task)
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
						@if(!\Auth::user()->hasRole('usuario'))
						<td class="mdl-data-table__cell--non-numeric">

							{{-- SHOW TASK ICON BUTTON --}}
							<a href="{{ route('task.show', $a_task->id) }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Ver detalle">
								<i class="material-icons">visibility</i>
							</a>

							{{-- EDIT TASK ICON BUTTON --}}
							<a href="{{ URL::to('task/' . $a_task->id . '/edit') }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Editar Actividad">
								<i class="material-icons">edit</i>
							</a>

							{{-- DELETE ICON BUTTON AND FORM CALL --}}
							{!! Form::open(array('url' => 'task/' . $a_task->id, 'class' => 'inline-block', 'id' => 'delete_'.$a_task->id)) !!}
							{!! Form::hidden('_method', 'DELETE') !!}
							<a href="#" class="dialog-button dialog-trigger-delete dialog-trigger{{$a_task->id}} mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" data-userid="{{$a_task->id}}" title="Eliminar Actividad">
								<i class="material-icons">delete_forever</i>
							</a>
							{!! Form::close() !!}
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="mdl-card__menu" style="top: -5px;">
		<a href="{{ url('/task/create') }}" class="mdl-button mdl-button--icon mdl-inline-expanded mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-color-text--white inline-block" title="Crear Actividad">
			<i class="material-icons">add</i>
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

@endsection

@section('template_scripts')

@include('scripts.mdl-datatables')

<script type="text/javascript">
	@foreach ($tasks as $a_task)
	mdl_dialog('.dialog-trigger{{$a_task->id}}','','#dialog_delete');
	@endforeach

	var dialog = document.querySelector('#dialog_delete');
	dialogPolyfill.registerDialog(dialog);

	$('.dialog-close').click(function(){
		$('.backdrop').css("z-index", -100001);
	});

	var userid;
	$('.dialog-trigger-delete').click(function(event) {
		event.preventDefault();
		$('.backdrop').css("z-index", 100001);
		userid = $(this).attr('data-userid');
	});
	$('#confirm').click(function(event) {
		$('form#delete_'+userid).submit();
	});
</script>

@endsection

@section('dialog_section')
@include('dialogs.dialog-delete')
<div class="backdrop" style="z-index: -100001;"></div>
@endsection