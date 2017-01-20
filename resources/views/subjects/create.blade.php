@extends('dashboard')

@section('template_title')
	Create New Subject
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
	Create New Subject
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
		<a itemprop="item" href="{{ url('/subject') }}">
			<span itemprop="name">
				Subject List
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="2" />
	</li>
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="{{ route('subject.create') }}">
			<span itemprop="name">
				Create New Subject
			</span>
		</a>
		<meta itemprop="position" content="3" />
	</li>
@endsection

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">
	    <div class="mdl-card card-new-user" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Create New Subject</h2>
			</div>

			{!! Form::open(array('action' => 'SubjectController@store', 'method' => 'POST', 'role' => 'form')) !!}

				<div class="mdl-card__supporting-text">
					<div class="mdl-grid full-grid padding-0">
						<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

							<div class="mdl-grid ">

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label {{ $errors->has('subject') ? 'is-invalid' :'' }}">
										{!! Form::text('subject', NULL, array('id' => 'subject', 'class' => 'mdl-textfield__input')) !!}
										{!! Form::label('subject', 'Subject', array('class' => 'mdl-textfield__label')); !!}
										<!-- <span class="mdl-textfield__error">Letters and numbers only</span> -->
									</div>
								</div>

								<div class="mdl-cell mdl-cell--4-col-tablet mdl-cell--6-col-desktop">
									<div class="mdl-js-textfield {{ $errors->has('priority') ? 'is-invalid' :'' }}">
									{!! Form::label('priority', 'Available priorities', array('class' => '')); !!}

									@foreach($priorities as $a_priority)
										<div class="mdl-cell mdl-cell--12-col-tablet mdl-cell--6-col-desktop">
											{!! Form::checkbox($a_priority->name, $a_priority->id, false) !!}
											{{ $a_priority->name }}
										</div>
									@endforeach
										<span class="" style="color: #d50000; position: absolute; font-size: 12px; margin-top: 3px; visibility:@if(!empty($error)) visible @else hidden @endif;display: block;">Select at least one priority</span>
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
								{!! Form::button('<i class="material-icons">save</i> Save New Subject', array('class' => 'dialog-button-save mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--green mdl-color-text--white mdl-button--raised margin-bottom-1 margin-top-1 margin-top-0-desktop margin-right-1 padding-left-1 padding-right-1 ')) !!}
							</span>

						</div>
					</div>
				</div>

			    <div class="mdl-card__menu mdl-color-text--white">

					{{-- SAVE ICON --}}
					<span class="save-actions">
						{!! Form::button('<i class="material-icons">save</i>', array('class' => 'dialog-button-icon-save mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect', 'title' => 'Save New Subject')) !!}
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