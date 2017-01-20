@extends('dashboard')

@section('template_title')
Editing {{ $task->user->first_name.' '.$task->user->last_name }} task
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
.rd-time-list{
	border: solid !important;
}
#description{
	height: 50px;
}
@endsection

@section('header')
Editing {{ $task->user->first_name.' '.$task->user->last_name }} task
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
	<a itemprop="item" href="{{ url('/task') }}">
		<span itemprop="name">
			Tasks List
		</span>
	</a>
	<i class="material-icons">chevron_right</i>
	<meta itemprop="position" content="2" />
</li>
<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="/task/{{ $task->id }}/edit">
		<span itemprop="name">
			Editing task #{{ $task->id }}
		</span>
	</a>
	<meta itemprop="position" content="4" />
</li>

@endsection

@section('content')

<?php 
	function toHours($minutes)
	{
		$hour = floor($minutes/60);
		$min = $minutes/60 - $hour;

		if ($min == 0) {
			return $hour.':00';
		} else {
			return $hour.':30';
		}
	}
?>

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">

		<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
			<h2 class="mdl-card__title-text">Editing task #{{ $task->id }}</h2>
		</div>

		{!! Form::model($task, array('action' => array('TaskController@update', $task->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}

		<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__supporting-text">
				<div class="mdl-grid full-grid padding-0">
					<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

						<div class="mdl-grid ">
							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('admin') ? 'is-invalid' :'' }}">
									{!! Form::select('admin', $analysts, $task->user->id, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'admin')) !!}
									<label for="admin">
										<i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									</label>
									{!! Form::label('admin', 'Assign admin', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
									<span class="mdl-textfield__error">Select admin</span>
								</div>
							</div>

							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('date') ? 'is-invalid' :'' }}">
								{!! Form::text('date', date('Y-m-d', strtotime($task->fecha)), array('id' => 'date', 'class' => 'mdl-textfield__input')) !!}
									{!! Form::label('date', 'Date', array('class' => 'mdl-textfield__label')); !!}
									<!-- <span class="mdl-textfield__error">Letters and numbers only</span> -->
								</div>
							</div>

							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('start_hour') ? 'is-invalid' :'' }}">
									{!! Form::text('start_hour', date('H:i', strtotime($task->hora_inicio)), array('id' => 'start_hour', 'class' => 'mdl-textfield__input')) !!}
									{!! Form::label('start_hour', 'Start hour', array('class' => 'mdl-textfield__label')); !!}
									<!-- <span class="mdl-textfield__error">Letters only</span> -->
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('hours') ? 'is-invalid' :'' }}">
									{!! Form::text('hours', toHours($task->cant_horas), array('id' => 'hours', 'class' => 'mdl-textfield__input')) !!}
									{!! Form::label('hours', 'Number of hours', array('class' => 'mdl-textfield__label')); !!}
									<!-- <span class="mdl-textfield__error">Letters only</span> -->
								</div>
							</div>

							<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('type') ? 'is-invalid' :'' }}">
									{!! Form::select('type', array('' => '', '1' => 'Presencial', '2' => 'Distancia'), $task->tipo, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'type')) !!}
									<label for="type">
										<i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									</label>
									{!! Form::label('type', 'Task type', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
									<span class="mdl-textfield__error">Select type</span>
								</div>
							</div>

							<div class="mdl-cell mdl-cell--12-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('description') ? 'is-invalid' :'' }}">
									{!! Form::textarea('description',  $task->descripcion, array('id' => 'description', 'class' => 'mdl-textfield__input')) !!}
									{!! Form::label('description', 'Description', array('class' => 'mdl-textfield__label')); !!}
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
							{!! Form::button('<i class="material-icons">save</i> <span class="hide-mobile">Save</span> <span class="hide-tablet">Changes</span>', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
						</span>
					</div>
				</div>
			</div>

			<div class="mdl-card__menu">

				{{-- SAVE ICON --}}
				<span class="save-actions">
					{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-button-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'Save Changes')) !!}
				</span>
			</div>

		</div>

		@include('dialogs.dialog-save')

		{!! Form::close() !!}

	</div>
</div>

@endsection

@section('template_scripts')

@include('scripts.mdl-required-input-fix')
@include('scripts.mdl-select')

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
	let hourspicker = rome(cant, {date:false, timeFormat: 'H:mm'});
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