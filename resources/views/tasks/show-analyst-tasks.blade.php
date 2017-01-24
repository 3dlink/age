@extends('dashboard')

@section('template_title')
Tasks
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
	Showing {{$user->first_name.' '.$user->last_name}}'s Tasks
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
		<a itemprop="item" href="{{ route('analysts') }}">
			<span itemprop="name">
				Analysts
			</span>
		</a>
		<i class="material-icons">chevron_right</i>
		<meta itemprop="position" content="1" />
	</li>
	<li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a itemprop="item" href="{{ route('task.index') }}" disabled>
			<span itemprop="name">
				Tasks List
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
			    {{ $total_tasks }} Task total
			@elseif ($total_tasks > 1)
			    {{ $total_tasks }} Total Tasks
			@else
			    No Tasks :(
			@endif
		</h2>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="mdl-data-table mdl-js-data-table data-table" cellspacing="0" width="100%">
			  <thead>
			    <tr>
					<th class="mdl-data-table__cell--non-numeric">Admin</th>
					<th class="mdl-data-table__cell--non-numeric">Client</th>
					<th class="mdl-data-table__cell--non-numeric">Date</th>
					<th class="mdl-data-table__cell--non-numeric">Start hour</th>
					<th class="mdl-data-table__cell--non-numeric">Number of hours</th>
					<th class="mdl-data-table__cell--non-numeric">Description</th>
					<th class="mdl-data-table__cell--non-numeric">Type</th>
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
							<td class="mdl-data-table__cell--non-numeric">{{$a_task->descripcion}}</td>
							<td class="mdl-data-table__cell--non-numeric">
							@if($a_task->tipo == 1)
								Presencial
							@elseif($a_task->tipo == 2)
								Distancia
							@endif
							</td>
						</tr>
			        @endforeach
			  </tbody>
			</table>
		</div>
	</div>
    <div class="mdl-card__menu" style="top: -5px;">
        <a href="{{ url('') }}" class="mdl-button mdl-button--icon mdl-inline-expanded mdl-js-button mdl-js-ripple-effect mdl-button--icon mdl-color-text--white inline-block" style="vertical-align: middle;">
			<i class="material-icons">get_app</i>
		</a>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable search-white"  style="vertical-align: middle;padding: 17px 0;">
			<label class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect mdl-button--icon" for="search_table">
			  	<i class="material-icons">search</i>
			</label>
			<div class="mdl-textfield__expandable-holder">
			  	<input class="mdl-textfield__input" type="search" id="search_table" placeholder="Search Terms">
			  	<label class="mdl-textfield__label" for="search_table">
			  		Search Terms
			  	</label>
			</div>
		</div>
    </div>
</div>

@endsection

@section('template_scripts')

	@include('scripts.mdl-datatables')

@endsection
