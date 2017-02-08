<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use App\Models\Priority;
use App\Models\Subject;
use Validator;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        $total_subjects = $subjects->count();

        return view('subjects.show', [
            'subjects' => $subjects, 
            'total_subjects' => $total_subjects
        ]);
    }

    public function validator(array $data){
        return Validator::make($data, [
            'subject'               => 'required',
            'Urgente'               => 'required_without_all:Baja,Media,Alta',
            'Alta'                  => 'required_without_all:Baja,Media',
            'Media'                 => 'required_without:Baja',
            'Baja'                  => ''
        ],[
            'subject.required'              => 'Ingrese un nombre para el Asunto',
            'Urgente.required_without_all'  => 'Debe seleccionar una prioridad',
            'Alta.required_without_all'     => 'Debe seleccionar una prioridad',
            'Media.required_without'        => 'Debe seleccionar una prioridad'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorities = Priority::all();

        return view('subjects.create', ['priorities' => $priorities]);
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
            $priorities = Priority::all();
            $subject = new Subject;
            $subject->subject = $request->input('subject');

            $priorityArray = [];
            foreach ($priorities as $a_priority) {
                if ($request->input($a_priority->name) != null) {
                    array_push($priorityArray, $request->input($a_priority->name));
                }
            }

            $subject->save();

            $subject->priorities()->attach($priorityArray);

            // THE SUCCESSFUL RETURN
            return redirect('subject')->with('status', 'Asunto creado éxitosamente!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $priorities = Priority::all();
        $subject = Subject::find($id);

        return view('subjects.edit', [
            'subject'       => $subject,
            'priorities'    => $priorities
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
            $priorities = Priority::all();
            $subject = Subject::find($id);
            $subject->subject = $request->input('subject');

            $priorityArray = [];
            foreach ($priorities as $a_priority) {
                if ($request->input($a_priority->name) != null) {
                    array_push($priorityArray, $request->input($a_priority->name));
                }
            }

            $subject->save();

            $subject->priorities()->detach();
            $subject->priorities()->attach($priorityArray);

            // THE SUCCESSFUL RETURN
            return redirect('subject')->with('status', 'Asunto actualizado éxitosamente');
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
        $subject = Subject::find($id);
        if (empty($subject->requirements)) {
            $subject->priorities()->detach();
            $subject->delete();
            return redirect('subject')->with('status', 'Asunto eliminado éxitosamente!');
        }
        return redirect('subject')->with('status', 'No se puede eliminar el Asunto');       
    }
}
