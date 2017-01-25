<style type="text/css">
	*{
		text-align: center;
	}
</style>

<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
	<div class="mdl-card__title mdl-color--primary mdl-color-text--white">
		<h2 class="mdl-card__title-text logo-style mdl-cell--4-col">
			@if ($tasksN->count() === 1)
			{{ $tasksN->count() }} Task in regular hours
			@elseif ($tasksN->count() > 1)
			{{ $tasksN->count() }} Tasks in regular hours
			@else
			No Tasks :(
			@endif
		</h2>

		<span class="mdl-cell--2-col">Total: {{$cantN}}/50</span>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Analyst</th>
						<th class="mdl-data-table__cell--non-numeric">Client</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
						<th class="mdl-data-table__cell--non-numeric">Start hour</th>
						<th class="mdl-data-table__cell--non-numeric">Number of hours</th>
						<th class="mdl-data-table__cell--non-numeric">Description</th>
						<th class="mdl-data-table__cell--non-numeric">Type</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tasksN as $a_task)
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
</div>

@if(!count($tasksE) == 0)
<div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
	<div class="mdl-card__title mdl-color--red mdl-color-text--white">
		<h2 class="mdl-card__title-text logo-style mdl-cell--4-col">
			@if ($tasksE->count() === 1)
			{{ $tasksE->count() }} Task in extra hours
			@elseif ($tasksE->count() > 1)
			{{ $tasksE->count() }} Tasks in extra hours
			@else
			No Tasks :(
			@endif
		</h2>
		<span class="mdl-cell--2-col">Total: {{$cantE}}</span>
	</div>
	<div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0">
		<div class="table-responsive material-table">
			<table id="user_table" class="" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Analyst</th>
						<th class="mdl-data-table__cell--non-numeric">Client</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
						<th class="mdl-data-table__cell--non-numeric">Start hour</th>
						<th class="mdl-data-table__cell--non-numeric">Number of hours</th>
						<th class="mdl-data-table__cell--non-numeric">Description</th>
						<th class="mdl-data-table__cell--non-numeric">Type</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tasksE as $a_task)
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
</div>
@endif