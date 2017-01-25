<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use App\Models\Subject;
use App\Models\Requirement;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Validator;
use Gravatar;
use Input;
use Image;
use File;
use Storage;

class RequirementController extends Controller
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
            $requirements = Requirement::all();
            $total_requirements = $requirements->count();
        } elseif ($user->hasRole('analista')) {
            $requirements = $user->assignments;
            $total_requirements = $requirements->count();
        } elseif ($user->hasRole('usuario')) {
            $requirements = $user->requirements;
            $total_requirements = $requirements->count();
        }

        return view('requirements.show', [
            'user'                    => $user,
            'requirements'            => $requirements,
            'total_requirements'      => $total_requirements
            ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        $subjectArray = array();
        $subjectArray[''] = '';
        foreach ($subjects as $a_sub) {
            $subjectArray[$a_sub->id] = $a_sub->subject;
        }

        $priorities = [];
        foreach ($subjects as $a_sub) {
            $p = [];
            foreach ($a_sub->priorities as $a_priority) {
                array_push($p, $a_priority->id);
            }
            $priorities[$a_sub->id] = $p;
        }

        return view('requirements.create', [
            'subjects'      => $subjectArray,
            'priorities'    => $priorities
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
        $create_new_validator = $this->create_new_validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
                );
        } else {
            $user = \Auth::user();
            
            $requirement                = new Requirement;
            $requirement->created_by    = $user->id;
            $requirement->subject_id    = $request->input('subject');
            $requirement->priority_id   = $request->input('priority');
            $requirement->description   = $request->input('description');

            if(Input::file('upload') != NULL && $requirement->save()){
                $upload             = Input::file('upload');
                $filename           = 'requirementFile.' . $upload->getClientOriginalExtension();
                $save_path          = '/users/id/' . $user->id . '/uploads/requirements/'.$requirement->id;

            // MAKE USER FOLDER AND UPDATE PERMISSIONS
                // File::makeDirectory($save_path, $mode = 0755, true, true);

            // SAVE FILE TO SERVER
                $upload->move(storage_path().$save_path, $filename);

            // SAVE ROUTED PATH TO FILE TO DATABASE
                $requirement->archive = '/files/users/' . $user->id . '/requirements/'. $requirement->id . '/' . $filename;
                $requirement->file_ext = $upload->getClientOriginalExtension();
            }

            $requirement->save();

            return redirect('requirement')->with('status', 'Successfully created requirement ticket!');
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
        $requirement = Requirement::find($id);

        return view('requirements.view', [
            'requirement'       => $requirement
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
        $requirement = Requirement::find($id);

        $current_subject = [];
        foreach ($requirement->subject->priorities as $a_p) {
            $current_subject[$a_p->id] = $a_p->name;
        }
        
        $subjects = Subject::all();
        $subjectArray = array();
        foreach ($subjects as $a_sub) {
            $subjectArray[$a_sub->id] = $a_sub->subject;
        }

        $priorities = [];
        foreach ($subjects as $a_sub) {
            $p = [];
            foreach ($a_sub->priorities as $a_priority) {
                array_push($p, $a_priority->id);
            }
            $priorities[$a_sub->id] = $p;
        }

        return view('requirements.edit', [
            'requirement'       => $requirement,
            'subjects'          => $subjectArray,
            'current_subject'   => $current_subject,
            'priorities'        => $priorities
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
        $create_new_validator = $this->create_new_validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
                );
        } else { 
            $user                       = \Auth::user();
            $requirement                = Requirement::find($id);
            $requirement->subject_id    = $request->input('subject');
            $requirement->priority_id   = $request->input('priority');
            $requirement->description   = $request->input('description');

            if(Input::file('upload') != NULL){
                $upload             = Input::file('upload');
                $filename           = 'requirementFile.' . $upload->getClientOriginalExtension();
                $save_path          = '\users\id\\' . $user->id . '\uploads\requirements\\'.$requirement->id;

            // SAVE FILE TO SERVER
                if (!empty($requirement->archive)) {
                    unlink(storage_path().$save_path. '\requirementFile.' . $requirement->file_ext);
                }

                $upload->move(storage_path().$save_path, $filename);

            // SAVE ROUTED PATH TO FILE TO DATABASE
                $requirement->archive = '/files/users/' . $user->id . '/requirements/'. $requirement->id . '/' . $filename;
                $requirement->file_ext = $upload->getClientOriginalExtension();
            }

            $requirement->save();

            return redirect('requirement')->with('status', 'Successfully updated requirement ticket!');
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
        // DELETE REQUIREMENT
        $requirement = Requirement::find($id);

        $save_path          = '\users\id\\' . $requirement->creator->id . '\uploads\requirements\\'. $id .'\requirementFile';
        unlink(storage_path().$save_path. '.' . $requirement->file_ext);

        $requirement->delete();

        return redirect('requirement')->with('status', 'Successfully deleted the requirement!');
    }

    public function create_new_validator(array $data)
    {
        return Validator::make($data, [
            'priority'              => 'required|exists:priorities,id',
            'subject'               => 'required|exists:subjects,id',
            'upload'                => 'mimes:doc,docx,pdf',
            'description'           => 'required'
            ]);
    }

    public function getRequirementFile($user, $id, $file)
    {
        $file_url = storage_path() . '/users/id/' . $user . '/uploads/requirements/'. $id . '/' . $file;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);
    }
}
