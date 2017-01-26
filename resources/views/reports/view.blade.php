@extends('dashboard')

@section('template_title')
Reporte
@endsection

@section('template_fastload_css')

@endsection

@section('header')
Reporte
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
	<a itemprop="item" href="{{ url('/report') }}">
		<span itemprop="name">
			Reportes
		</span>
	</a>
	<i class="material-icons">chevron_right</i>
	<meta itemprop="position" content="2" />
</li>
<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a itemprop="item" href="#">
		<span itemprop="name">
			Reporte
		</span>
	</a>
	<meta itemprop="position" content="3" />
</li>
@endsection

<div class="mdl-grid full-grid margin-top-0 padding-0">
	<div class="mdl-cell mdl-cell mdl-cell--12-col mdl-cell--12-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop mdl-card mdl-shadow--3dp margin-top-0 padding-top-0">
		<div class="mdl-card card-new-user" style="width:100%;" itemscope itemtype="http://schema.org/Person">

			<div class="mdl-card__title mdl-card--expand mdl-color--primary mdl-color-text--white">
				<h2 class="mdl-card__title-text">Reporte</h2>
			</div>

			<div class="mdl-card card-wide" style="width:100%;" itemscope itemtype="http://schema.org/Person">
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid full-grid padding-0">
						<div class="mdl-cell mdl-cell--12-col-phone mdl-cell--12-col-tablet mdl-cell--12-col-desktop">

							<div class="mdl-grid ">

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Nombre: </label>
									{{str_replace('_',' ', $report->name)}}
								</div>

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Cliente: </label>
									{{$report->client->first_name.' '.$report->client->last_name}}
								</div>

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Subido por: </label>
									{{$report->owner->first_name.' '.$report->owner->last_name}}
								</div>

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Subido el: </label>
									{{date('d/m/Y', strtotime($report->created_at))}}
								</div>

								<div class="mdl-cell mdl-cell--12-col">
									<label class="mdl-color-text--indigo">Descripción: </label>
									<br>
									{{$report->description}}
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