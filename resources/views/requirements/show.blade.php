@extends('dashboard')

@section('template_title')
Tickets de Requerimiento
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
	Mostrando Todos los Tickets de Requerimiento
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
				Tickets de Requerimiento
			</span>
		</a>
		<meta itemprop="position" content="2" />
	</li>
@endsection

@section('content')

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
	<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
		<h2 class="mdl-card__title-text logo-style">
			@if ($total_requirements === 1)
			    {{ $total_requirements }} Ticket de Requerimiento en Total
			@elseif ($total_requirements > 1)
			    {{ $total_requirements }} Tickets de Requerimiento en Total
			@else
			    Sin Tickets de Requerimiento :(
			@endif
		</h2>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="mdl-data-table mdl-js-data-table data-table" cellspacing="0" width="100%">
			  <thead>
			    <tr>
			    	<th class="mdl-data-table__cell--non-numeric">#Ticket</th>
					<th class="mdl-data-table__cell--non-numeric">Asunto</th>
					<th class="mdl-data-table__cell--non-numeric">Prioridad</th>
					<!-- <th class="mdl-data-table__cell--non-numeric">Description</th> -->
					<th class="mdl-data-table__cell--non-numeric">Analista asignado</th>
					<th class="mdl-data-table__cell--non-numeric">Creado por</th>
					<th class="mdl-data-table__cell--non-numeric">Fecha de creación</th>
					<th class="mdl-data-table__cell--non-numeric no-sort no-search">Acciones</th>
			    </tr>
			  </thead>
			  <tbody>
			        @foreach ($requirements as $a_req)
						<tr
						@if ((\Auth::user()->hasRole('supervisor') || \Auth::user()->hasRole('super administrador')) && empty($a_req->analyst)) style="background-color: aliceblue;" @endif>
							<td class="mdl-data-table__cell--non-numeric">{{$a_req->id}}</td>
							<td class="mdl-data-table__cell--non-numeric">{{$a_req->subject->subject}}</td>
							<td class="mdl-data-table__cell--non-numeric">{{$a_req->priority->name}}</td>
							<!-- <td class="mdl-data-table__cell--non-numeric">{{$a_req->description}}</td> -->
							<td class="mdl-data-table__cell--non-numeric">
							@if(!empty($a_req->analyst))
							{{$a_req->analyst->first_name.' '.$a_req->analyst->last_name}}</td>
							@else
							Unnasigned
							@endif
							<td class="mdl-data-table__cell--non-numeric">{{$a_req->creator->first_name.' '.$a_req->creator->last_name}}</td>
							<td class="mdl-data-table__cell--non-numeric">{{date('d/m/Y', strtotime($a_req->created_at))}}</td>
							<td class="mdl-data-table__cell--non-numeric">
								{{-- DOWNLOAD REQUIREMENT ARCHIVE ICON BUTTON --}}
								@if(!empty($a_req->archive))
								<a href="{{ url($a_req->archive) }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Descargar archivo adjunto">
									<i class="material-icons">get_app</i>
								</a>
								@endif

								@if(\Auth::user()->hasRole('supervisor') || \Auth::user()->hasRole('super administrador'))
									@if(!empty($a_req->analyst))
									<a href="{{ URL::to('requirement/assign/' . $a_req->id . '/edit') }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Cambiar Analista">
										<i class="material-icons">perm_identity</i>
									</a>
									@else
									<a href="{{ url('requirement/assign/create/'.$a_req->id) }}" class="mdl-button mdl-button--icon mdl-inline-expanded mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-color-text--white inline-block" title="Asignar Analista">
										<i class="material-icons">person_add</i>
									</a>
									@endif
								@endif

								{{-- SHOW REQUIREMENT ICON BUTTON --}}
								<a href="{{ route('requirement.show', $a_req->id) }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Ver detalle">
									<i class="material-icons">visibility</i>
								</a>
								@if(\Auth::user()->hasRole('super administrador') || \Auth::user()->hasRole('supervisor'))
								{{-- EDIT REQUIREMENT ICON BUTTON --}}
								<a href="{{ URL::to('requirement/' . $a_req->id . '/edit') }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="Editar Requerimiento">
									<i class="material-icons">edit</i>
								</a>
								@if(\Auth::user()->hasRole('super administrador'))
								{{-- DELETE ICON BUTTON AND FORM CALL --}}
								{!! Form::open(array('url' => 'requirement/' . $a_req->id, 'class' => 'inline-block', 'id' => 'delete_'.$a_req->id)) !!}
									{!! Form::hidden('_method', 'DELETE') !!}
									<a href="#" class="dialog-button dialog-trigger-delete dialog-trigger{{$a_req->id}} mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" data-userid="{{$a_req->id}}" title="Eliminar Requerimiento">
										<i class="material-icons">delete_forever</i>
									</a>
								{!! Form::close() !!}
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
    	@if(\Auth::user()->hasRole('super administrador') || \Auth::user()->hasRole('usuario'))
		<a href="{{ url('/requirement/create') }}" class="mdl-button mdl-button--icon mdl-inline-expanded mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-color-text--white inline-block" title="Generar Ticket de Requerimiento">
			<i class="material-icons">add</i>
		</a>
		@endif
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
		@foreach ($requirements as $a_req)
			mdl_dialog('.dialog-trigger{{$a_req->id}}','','#dialog_delete');
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