<style type="text/css">
	td{
		text-align: center;
	}
</style>

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
					<th class="mdl-data-table__cell--non-numeric">ID</th>
					<th class="mdl-data-table__cell--non-numeric">Admin</th>
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
							<td class="mdl-data-table__cell--non-numeric">{{$a_task->id}}</td>
							<td class="mdl-data-table__cell--non-numeric">{{$a_task->user->first_name.' '.$a_task->user->last_name}}</td>
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
