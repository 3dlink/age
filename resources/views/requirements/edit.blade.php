@extends('dashboard')

@section('template_title')
Editando Ticket de Requerimiento
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
.file_upload_container{
position: relative;
width: 100%;
left: 0;
}
#file_upload_text_div{
float: left;
margin-left: 0;
}
@endsection

@section('header')
Editando Ticket de Requerimiento
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
	<a itemprop="item" href="{{ url('/requirement') }}">
		<span itemprop="name">
			Tickets de Requerimiento
		</span>
	</a>
	<i class="material-icons">chevron_right</i>
	<meta itemprop="position" content="2" />
</li>
<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="#">
		<span itemprop="name">
			Editando Ticket de Requerimiento
		</span>
	</a>
	<meta itemprop="position" content="3" />
</li>
@endsection

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">
		<div class="mdl-card card-new-user" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Editando Ticket de Requerimiento</h2>
			</div>

			{!! Form::model($requirement, array('action' => array('RequirementController@update', $requirement->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}

			<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid full-grid padding-0">
						<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

							<div class="mdl-grid ">

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('subject') ? 'is-invalid' :'' }}">
										{!! Form::select('subject', $subjects, $requirement->subject_id, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'subject')) !!}
									    <label for="subject">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('subject', 'Selecciona un Asunto', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('priority') ? 'is-invalid' :'' }}">
										{!! Form::select('priority', $current_subject, $requirement->priority_id, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'priority')) !!}
									    <label for="priority">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('priority', 'Selecciona una prioridad', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>

							  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="file_upload_container">
									    <div id="file_upload_text_div" class="mdl-textfield mdl-js-textfield">
											<input class="file_upload_text mdl-textfield__input mdl-color-text--white mdl-file-input" type="text" disabled readonly id="file_upload_text"/>
											<label class="mdl-textfield__label profile_pic_label" for="file_upload_text">Archivo Adjunto</label>
									    </div>
									    <div class="file_upload_btn">
									     	<label class="image_input_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-color-text--white">
									        	<i class="material-icons">description</i>

									       		{!! Form::file('upload',  array('id' => 'file_upload_btn', 'class' => 'hidden mdl-file-input', 'accept' => ".doc, .docx, .pdf, images/*")) !!}
									      	</label>
									    </div>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--12-col">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('description') ? 'is-invalid' :'' }}">
								        {!! Form::textarea('description',  $requirement->decription, array('id' => 'description', 'class' => 'mdl-textfield__input')) !!}
								        {!! Form::label('description', 'Descripción', array('class' => 'mdl-textfield__label')); !!}
								    </div>
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
							{!! Form::button('<i class="material-icons">save</i> <span class="hide-mobile">Guardar</span> <span class="hide-tablet">Cambios</span>', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
						</span>
					</div>
				</div>
			</div>

			<div class="mdl-card__menu">

				{{-- SAVE ICON --}}
				<span class="save-actions">
					{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-button-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'Guardar Cambios')) !!}
				</span>
			</div>

		</div>

		@include('dialogs.dialog-save')

		{!! Form::close() !!}
	</div>
</div>
</div>

@endsection

@section('template_scripts')

@include('scripts.mdl-required-input-fix')
@include('scripts.mdl-select')
@include('scripts.mdl-file-upload')

<script type="text/javascript">
	var priorities = {};
	var aux = new Array();
	<?php foreach($priorities as $key => $val){ ?>
		aux = [];
		<?php foreach ($val as $id): ?>
		aux.push('<?php echo $id ?>');
	<?php endforeach ?>
	priorities['<?php echo $key ?>'] = aux;
	<?php } ?>

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

	$('#subject').on('change', function function_name(argument) {
		let array = priorities[$(this).val()];
		let html = '';

		html += '';
		html += '<option value="" selected="selected"></option>';
		if (array) {
			for (let i = 0; i < array.length; i++) {
				let option = array[i];
				if (option == '1') {
					html += '<option value="4">Baja</option>';
				} else if (option == '2') {
					html += '<option value="3">Media</option>';
				} else if (option == '3'){
					html += '<option value="2">Alta</option>';
				} else if (option == '4'){
					html += '<option value="1">Urgente</option>';
				}
			}
		}

		$('#priority').html(html);

	});
</script>

@endsection

@section('dialog_section')
<!-- @include('dialogs.dialog-save') -->
<div class="backdrop" style="z-index: -100001;"></div>
@endsection