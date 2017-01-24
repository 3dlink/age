<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
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

class AssignRequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $requirement 		= Requirement::find($id);
        $analysts			= User::find($requirement->created_by)->analysts;

        $analystsArray 		= array();
        $analystsArray[''] 	= '';

        foreach ($analysts as $analyst) {
            $analystsArray[$analyst->id] = $analyst->first_name." ".$analyst->last_name;       
        }

        return view('requirements.assign', [
        	'requirement'	=> $requirement,
            'analysts'   	=> $analystsArray
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
        $assignmentValidator = $this->assignmentValidator($request->all());

        if ($assignmentValidator->fails()) {
            $this->throwValidationException(
                $request, $assignmentValidator
                );
        } else {
        	$analyst 		= User::find($request->input('analyst'));
        	$requirement 	= Requirement::find($request->input('requirement'));

        	$analyst->assignments()->save($requirement);
        }

        return redirect('requirement')->with('status', 'Successfully assigned analyst!');
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
        $requirement 		= Requirement::find($id);
        $analysts			= User::find($requirement->created_by)->analysts;

        $analystsArray 		= array();

        foreach ($analysts as $analyst) {
            $analystsArray[$analyst->id] = $analyst->first_name." ".$analyst->last_name;       
        }

        return view('requirements.reassign', [
        	'requirement'	=> $requirement,
            'analysts'   	=> $analystsArray
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
        $assignmentValidator = $this->assignmentValidator($request->all());

        if ($assignmentValidator->fails()) {
            $this->throwValidationException(
                $request, $assignmentValidator
                );
        } else {
        	$analyst 		= User::find($request->input('analyst'));
        	$requirement 	= Requirement::find($request->input('requirement'));

        	$analyst->assignments()->save($requirement);
        }

        return redirect('requirement')->with('status', 'Successfully updated analyst!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = User::find($id);
        $client->analysts()->detach();

        return redirect('assignments')->with('status', 'Successfully deleted analysts assignment!');
    }

    public function assignmentValidator(array $data)
    {
        return Validator::make($data, [
            'requirement'   => 'required|exists:requirements,id',
            'analyst'		=> 'required|exists:users,id'
        ]);
    }
}
