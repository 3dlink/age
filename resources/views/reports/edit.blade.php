@extends('dashboard')

@section('template_title')
Editando Reporte
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
#description{
	height: 50px;
}
@endsection

@section('header')
Editando Reporte
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
	<a itemprop="item" href="{{ url('/report') }}">
		<span itemprop="name">
			Reportes
		</span>
	</a>
	<i class="material-icons">chevron_right</i>
	<meta itemprop="position" content="2" />
</li>
<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="/report/{{ $report->id }}/edit">
		<span itemprop="name">
			Editando Reporte
		</span>
	</a>
	<meta itemprop="position" content="4" />
</li>

@endsection

@section('content')

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">

		{!! Form::model($report, array('action' => array('ReportController@update', $report->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}

		<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">
			<div class="mdl-card__supporting-text">
				<div class="mdl-grid full-grid padding-0">
					<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

						<div class="mdl-grid ">

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('name') ? 'is-invalid' :'' }}">
										{!! Form::text('name', str_replace('_',' ', $report->name), array('id' => 'name', 'class' => 'mdl-textfield__input')) !!}
										{!! Form::label('name', 'Nombre', array('class' => 'mdl-textfield__label')); !!}
										<!-- <span class="mdl-textfield__error">Letters and numbers only</span> -->
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('client') ? 'is-invalid' :'' }}">
										{!! Form::select('client', $clients, $report->client->id, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'client')) !!}
									    <label for="client">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('client', 'Selecciona un Cliente', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error"></span>
									</div>
								</div>

							  	<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="file_upload_container">
									    <div id="file_upload_text_div" class="mdl-textfield mdl-js-textfield">
											<input class="file_upload_text mdl-textfield__input mdl-color-text--white mdl-file-input" type="text" disabled readonly id="file_upload_text" accept=".pdf"/>
											<label class="mdl-textfield__label profile_pic_label" for="file_upload_text">Archivo de Reporte</label>
									    </div>
									    <div class="file_upload_btn">
									     	<label class="image_input_button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-color-text--white">
									        	<i class="material-icons">description</i>

									       		{!! Form::file('upload',  array('id' => 'file_upload_btn', 'class' => 'hidden mdl-file-input', 'accept' => ".doc, .docx, .pdf")) !!}
									      	</label>
									    </div>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--12-col">
								    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('description') ? 'is-invalid' :'' }}">
								        {!! Form::textarea('description',  $report->description, array('id' => 'description', 'class' => 'mdl-textfield__input')) !!}
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

@endsection

@section('template_scripts')

@include('scripts.mdl-required-input-fix')
@include('scripts.mdl-select')
@include('scripts.mdl-file-upload')

<script type="text/javascript">
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