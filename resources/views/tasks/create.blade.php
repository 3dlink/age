@extends('dashboard')

@section('template_title')
	Crear Actividad
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
	Crear Actividad
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
		<a itemprop="item" href="{{ url('/task') }}">
			<span itemprop="name">
				Actividades
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="2" />
	</li>
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="{{ route('task.create') }}">
			<span itemprop="name">
				Crear Actividad
			</span>
		</a>
		<meta itemprop="position" content="3" />
	</li>
@endsection

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">
	    <div class="mdl-card card-new-user" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Crear Actividad</h2>
			</div>

			{!! Form::open(array('action' => 'TaskController@store', 'method' => 'POST', 'role' => 'form')) !!}

				<div class="mdl-card__supporting-text">
					<div class="mdl-grid full-grid padding-0">
						<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

							<div class="mdl-grid ">
							@if(!\Auth::user()->hasRole('analista'))
								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('admin') ? 'is-invalid' :'' }}">
										{!! Form::select('admin', $analysts, NULL, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'admin')) !!}
									    <label for="admin">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('admin', 'Seleccionar Analista', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>
							@else
							{!! Form::select('admin', $analysts, NULL, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'admin', 'hidden')) !!}
							@endif

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('client') ? 'is-invalid' :'' }}">
										{!! Form::select('client', $clients, NULL, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'client')) !!}
									    <label for="client">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('client', 'Seleccionar Cliente', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('date') ? 'is-invalid' :'' }}">
										{!! Form::text('date', NULL, array('id' => 'date', 'class' => 'mdl-textfield__input')) !!}
										{!! Form::label('date', 'Fecha', array('class' => 'mdl-textfield__label')); !!}
										<!-- <span class="mdl-textfield__error">Letters and numbers only</span> -->
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
							        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('start_hour') ? 'is-invalid' :'' }}">
							            {!! Form::text('start_hour', NULL, array('id' => 'start_hour', 'class' => 'mdl-textfield__input')) !!}
							            {!! Form::label('start_hour', 'Hora de inicio', array('class' => 'mdl-textfield__label')); !!}
							            <!-- <span class="mdl-textfield__error">Letters only</span> -->
							        </div>
							  	</div>
							  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('hours') ? 'is-invalid' :'' }}">
								        {!! Form::text('hours', NULL, array('id' => 'hours', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('hours', 'Duración', array('class' => 'mdl-textfield__label')); !!}
								        <!-- <span class="mdl-textfield__error">Letters only</span> -->
								    </div>
							  	</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('type') ? 'is-invalid' :'' }}">
										{!! Form::select('type', array('' => '', '1' => 'Presencial', '2' => 'Distancia'), NULL, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'type')) !!}
									    <label for="type">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('type', 'Tipo de actividad', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--12-col">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('description') ? 'is-invalid' :'' }}">
								        {!! Form::textarea('description',  NULL, array('id' => 'description', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('description', 'Descripción', array('class' => 'mdl-textfield__label')); !!}
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
								{!! Form::button('<i class="material-icons">save</i> Guardar Actividad', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
							</span>

						</div>
					</div>
				</div>

			    <div class="mdl-card__menu mdl-color-text--white">

					{{-- SAVE ICON --}}
					<span class="save-actions">
						{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-button-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'Guardar Actividad')) !!}
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

	<script type="text/javascript">
		let date = document.getElementById('date');
		let datepicker = rome(date, {time:false, inputFormat: "YYYY-MM-DD"});

		datepicker.on('hide', function(){
			let f = $('#date');
			if (f.val() != "") {
				f.parent().addClass('is-dirty');
			}
		});

		let hour = document.getElementById('start_hour');
		let timepicker = rome(hour, {date:false});
		timepicker.on('hide', function(){
			let t = $('#start_hour');
			if (t.val() != "") {
				t.parent().addClass('is-dirty');	
			}
		});

		let cant = document.getElementById('hours');
		let hourspicker = rome(cant, {date:false, timeFormat: 'H:mm', initialValue: '0:00'});
		hourspicker.on('hide', function(){
			let t = $('#hours');
			if (t.val() != "") {
				t.parent().addClass('is-dirty');	
			}
		});

		mdl_dialog('.dialog-button-save');
		mdl_dialog('.dialog-button-icon-save');

		let dialog = document.querySelector('#dialog');
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