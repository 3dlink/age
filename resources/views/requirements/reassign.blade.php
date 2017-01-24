@extends('dashboard')

@section('template_title')
	Assign Analyst
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
	Assign Analyst
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
				Requirement Ticket List
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="2" />
	</li>
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="{{ route('analyst.assign') }}">
			<span itemprop="name">
				Assign Analyst
			</span>
		</a>
		<meta itemprop="position" content="3" />
	</li>
@endsection

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">
	    <div class="mdl-card card-new-user" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Assign Analyst</h2>
			</div>

			{!! Form::model($requirement, array('action' => array('AssignRequirementController@update', $requirement->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}

				<div class="mdl-card__supporting-text">
					<div class="mdl-grid full-grid padding-0">
						<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

							<div class="mdl-grid ">
								<div class="mdl-cell mdl-cell--12-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('analyst') ? 'is-invalid' :'' }}">
										{!! Form::select('analyst', $analysts, $requirement->analyst->id, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'analyst')) !!}
									    <label for="analyst">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('analyst', 'Analyst', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error">Select analyst</span>
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop hidden">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-select mdl-select__fullwidth {{ $errors->has('requirement') ? 'is-invalid' :'' }}">
										{!! Form::select('requirement', [$requirement->id => $requirement->id], $requirement->id, array('class' => 'mdl-selectfield__select mdl-textfield__input', 'id' => 'requirement')) !!}
									    <label for="requirement">
									        <i class="mdl-icon-toggle__label material-icons">arrow_drop_down</i>
									    </label>
										{!! Form::label('requirement', 'requirement', array('class' => 'mdl-textfield__label mdl-selectfield__label')); !!}
										<span class="mdl-textfield__error">Select requirement</span>
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
								{!! Form::button('<i class="material-icons">save</i> Save Assignment', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
							</span>

						</div>
					</div>
				</div>

			    <div class="mdl-card__menu mdl-color-text--white">

					{{-- SAVE ICON --}}
					<span class="save-actions">
						{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-button-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'Save Assignment')) !!}
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
	@include('scripts.mdl-select')

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