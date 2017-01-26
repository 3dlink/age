<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use App\Models\Role;
use App\Models\Task;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Validator;
use PDF;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        if ($user->hasRole('supervisor') || $user->hasRole('super administrador')) {
            $tasks = Task::all();
        } elseif ($user->hasRole('analista')) {
            $tasks = $user->tasks;
        } elseif ($user->hasRole('usuario')){
            $tasks = Task::where('client_id', $user->id)->get();
        }

        $total_tasks = $tasks->count();

        return view('tasks.show', [
            'user'                    => $user,
            'tasks'                   => $tasks,
            'total_tasks'             => $total_tasks
            ]
            );
    }

    public function validator(array $data){
        $clientsString = ':0';
        if (!empty($data['admin'])) {
         $clients = User::find($data['admin'])->clients;
         $clientsString = ':';
         $i = 1;
         foreach ($clients as $key) {
            $clientsString .= $key->id;
            if ($i != $clients->count()) {
                $clientsString .= ',';
            }
            $i++;
        }
    }


    return Validator::make($data, [
        'date'              => 'required|date_format:Y-m-d',
        'start_hour'        => 'required|date_format:H:i',
        'hours'             => 'required',
        'description'       => 'required',
        'type'              => 'required',
        'admin'             => 'required|integer|exists:users,id',
        'client'            => 'required|in'.$clientsString
        ], [
        'client.in'                 => 'El Cliente seleccionado no esta asignado al Analista seleccionado',
        'date.required'             => 'Ingrese una fecha',
        'date.date_format'          => 'El formato de la fecha no es correcto',
        'start_hour.required'       => 'Ingrese una hora de inicio',
        'start_hour.date_format'    => 'El formato de la hora no es correcto',
        'hours.required'            => 'Ingrese una duración',
        'description.required'      => 'Ingrese una descripción',
        'type.required'             => 'Ingrese un tipo de actividad',
        'admin.required'            => 'Seleccione un Analista',
        'admin.exists'              => 'El Analista seleccionado no existe',
        'client.required'           => 'Seleccione un Cliente'
        ]);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        if ($user->role_id == 3) {
            $analystsArray[$user->id] = $user->first_name." ".$user->last_name;
            $clients = $user->clients;
        } else {
            $analysts = User::wherein('role_id', [2,3])->get();
            $analystsArray = array();
            $analystsArray[''] = '';
            foreach ($analysts as $a_analyst) {
                $analystsArray[$a_analyst->id] = $a_analyst->first_name." ".$a_analyst->last_name;
            }
            $clients = User::where('role_id', 4)->get();
        }

        $clientsArray = [];
        $clientsArray[''] = ''; 
        foreach ($clients as $a_client) {
            $clientsArray[$a_client->id] = $a_client->first_name.' '.$a_client->last_name;
        }
        
        return view('tasks.create', [
            'analysts'  => $analystsArray,
            'clients'   => $clientsArray
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $create_new_validator = $this->validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
                );
        } else {
            $task = new Task;
            $task->fecha            = $request->input('date');
            $task->hora_inicio      = $request->input('start_hour');
            $task->cant_horas       = $this->transformHours($request->input('hours'));
            $task->descripcion      = $request->input('description');
            $task->tipo             = $request->input('type');
            $task->client_id        = $request->input('client');

            $task->save();

            $user = User::find($request->input('admin'));
            $user->tasks()->save($task);

            // THE SUCCESSFUL RETURN
            return redirect('task')->with('status', 'Actividad creada éxitosamente!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);

        return view('tasks.view', [
            'task'      => $task
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);

        $user = \Auth::user();
        if ($user->role_id == 3) {
            $analystsArray[$user->id] = $user->first_name." ".$user->last_name;
            $clients = $user->clients;
        } else {
            $analysts = User::wherein('role_id', [2,3])->get();
            $analystsArray = array();
            foreach ($analysts as $a_analyst) {
                $analystsArray[$a_analyst->id] = $a_analyst->first_name." ".$a_analyst->last_name;
            }
            $clients = User::where('role_id', 4)->get();
        }

        $clientsArray = [];
        foreach ($clients as $a_client) {
            $clientsArray[$a_client->id] = $a_client->first_name.' '.$a_client->last_name;
        }

        return view('tasks.edit', [
            'task'      => $task,
            'analysts'  => $analystsArray,
            'clients'   => $clientsArray
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $create_new_validator = $this->validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
                );
        } else {
            $task = Task::find($id);
            $task->fecha            = $request->input('date');
            $task->hora_inicio      = $request->input('start_hour');
            $task->cant_horas       = $this->transformHours($request->input('hours'));
            $task->descripcion      = $request->input('description');
            $task->tipo             = $request->input('type');
            $task->client_id        = $request->input('client');

            $task->save();

            $user = User::find($request->input('admin'));
            $user->tasks()->save($task);

            // THE SUCCESSFUL RETURN
            return redirect('task')->with('status', 'Actividad actualizada éxitosamente!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DELETE TASK
        $task = Task::find($id);
        $task->delete();

        return redirect('task')->with('status', 'Actividad eliminada éxitosamente!');
    }

    public function transformHours($hours)
    {
        $horas = substr($hours, 0, 2);
        $minutos = substr($hours, 3, 2);

        return $horas*60 + $minutos;
    }

    public function getPDF($username, $year, $week)
    {
        $user       = \Auth::user();
        $analyst    = User::where('name',$username)->get();
        $analyst    = $analyst[0];

        $tasks      = Task::where([['client_id', $user->id], ['user_id', $analyst->id]])->get();

        $tasksArray = collect();

        foreach ($tasks as $a_task) {
            $date = $a_task->fecha;
            if (date("W", strtotime($date)) == $week && date("Y", strtotime($date)) == $year) {
                $tasksArray->push($a_task);
            }
        }

        $normalTasks = collect();
        $extraTasks = collect();

        $normal_hours = 0;
        $extra_hours = 0;

        foreach ($tasksArray as $a_task) {
            if ($normal_hours < 50) {
                if ($normal_hours + ($a_task->cant_horas)/60 <= 50) {
                    $normal_hours +=  ($a_task->cant_horas)/60;
                } else {
                    $normal_hours +=  ($a_task->cant_horas)/60;
                    $diff = $normal_hours - 50;
                    $normal_hours -= $diff;
                    $extra_hours += $diff;

                    $aux                    = new Task;
                    $aux->fecha             = $a_task->fecha;
                    $aux->hora_inicio       = $a_task->hora_inicio;
                    $aux->cant_horas        = $diff*60;
                    $aux->descripcion       = $a_task->descripcion;
                    $aux->tipo              = $a_task->tipo;
                    $aux->user_id           = $a_task->user_id;
                    $aux->client_id         = $a_task->client_id;

                    $extraTasks->push($aux);
                    $a_task->cant_horas -= $diff*60;
                }
                $normalTasks->push($a_task);
            } else {
                $extraTasks->push($a_task);
                $extra_hours += ($a_task->cant_horas)/60;
            }
        }

        $pdf = PDF::loadView('tasks.pdf', [
            'user'              => $analyst,
            'tasksN'            => $normalTasks,
            'tasksE'            => $extraTasks,
            'cantN'             => $normal_hours,
            'cantE'             => $extra_hours,
            'total_hours'       => $normal_hours + $extra_hours
            ]
            )->setPaper('a4', 'landscape');

        return $pdf->download($analyst->last_name.'_'.$analyst->first_name.'_actividades_semana_'.$week.'_año_    '.$year.'.pdf');
    }

    public function getAnalystTasks($username, $year, $week)
    {
        $user       = \Auth::user();
        $analyst    = User::where('name',$username)->get();
        $analyst    = $analyst[0];

        $tasks      = Task::where([['client_id', $user->id], ['user_id', $analyst->id]])->get();

        $tasksArray = collect();

        foreach ($tasks as $a_task) {
            $date = $a_task->fecha;
            if (date("W", strtotime($date)) == $week && date("Y", strtotime($date)) == $year) {
                $tasksArray->push($a_task);
            }
        }

        $normalTasks = collect();
        $extraTasks = collect();

        $normal_hours = 0;
        $extra_hours = 0;

        foreach ($tasksArray as $a_task) {
            if ($normal_hours < 50) {
                if ($normal_hours + ($a_task->cant_horas)/60 <= 50) {
                    $normal_hours +=  ($a_task->cant_horas)/60;
                } else {
                    $normal_hours +=  ($a_task->cant_horas)/60;
                    $diff = $normal_hours - 50;
                    $normal_hours -= $diff;
                    $extra_hours += $diff;

                    $aux                    = new Task;
                    $aux->fecha             = $a_task->fecha;
                    $aux->hora_inicio       = $a_task->hora_inicio;
                    $aux->cant_horas        = $diff*60;
                    $aux->descripcion       = $a_task->descripcion;
                    $aux->tipo              = $a_task->tipo;
                    $aux->user_id           = $a_task->user_id;
                    $aux->client_id         = $a_task->client_id;

                    $extraTasks->push($aux);
                    $a_task->cant_horas -= $diff*60;
                }
                $normalTasks->push($a_task);
            } else {
                $extraTasks->push($a_task);
                $extra_hours += ($a_task->cant_horas)/60;
            }
        }

        return view('tasks.show-analyst-tasks', [
            'user'              => $analyst,
            'tasksN'            => $normalTasks,
            'tasksE'            => $extraTasks,
            'cantN'             => $normal_hours,
            'cantE'             => $extra_hours,
            'total_hours'       => $normal_hours + $extra_hours,
            'week'              => $week,
            'year'              => $year
            ]);
    }

    public function getAssignedAnalystsView()
    {
        if (\Auth::user()->role_id == 4) {
            $user = \Auth::user();
            $analysts = \Auth::user()->analysts;
            return view('tasks.show-analysts', [
              'user'                    => $user,
              'users'                   => $analysts,
              'total_users'             => $analysts->count()
              ]);
        }

        return redirect('/');
    }

    public function showAnalyst($year, $week, $id)
    {
        $task = Task::find($id);

        return view('tasks.view-analyst-task', [
            'task'      => $task,
            'year'      => $year,
            'week'      => $week
            ]);        
    }
}
