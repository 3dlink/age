@extends('dashboard')

@section('template_title')
Ticket de Requerimiento
@endsection

@section('template_fastload_css')

@endsection

@section('header')
Ticket de Requerimiento
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
			Listado de Tickets de Requerimiento
		</span>
	</a>
	<i class="material-icons">chevron_right</i>
	<meta itemprop="position" content="2" />
</li>
<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="#">
		<span itemprop="name">
			Ticket de Requerimiento
		</span>
	</a>
	<meta itemprop="position" content="3" />
</li>
@endsection

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">
		<div class="mdl-card card-new-user" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Ticket de Requerimiento</h2>
			</div>

			<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid full-grid padding-0">
						<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

							<div class="mdl-grid">

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Asunto: </label>
									{{$requirement->subject->subject}}
								</div>

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Prioridad: </label>
									{{$requirement->priority->name}}
								</div>

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Analista asignado: </label>
									@if(!empty($requirement->analyst))
									{{$requirement->analyst->first_name.' '.$requirement->analyst->last_name}}</td>
									@else
									Sin asignar
									@endif
								</div>

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Descripción: </label>
									<br>
									{{$requirement->description}}
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

@endsection