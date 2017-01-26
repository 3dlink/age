<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Models\Profile;
use App\Http\Requests;
use App\Models\User;
use App\Models\Report;

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

class ReportController extends Controller
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
            $reports = Report::all();
            $total_reports = $reports->count();
        } elseif ($user->hasRole('analista')) {
            $reports = $user->uploads;
            $total_reports = $reports->count();
        } elseif ($user->hasRole('usuario')) {
            $reports = $user->reports;
            $total_reports = $reports->count();
        }

        return view('reports.show', [
            'user'                    => $user,
            'reports'                 => $reports,
            'total_reports'           => $total_reports
        ]);
    }

    public function create_validator(array $data){
        return Validator::make($data, [
            'name'              => 'required',
            'upload'            => 'required|mimes:doc,docx,pdf',
            'description'       => 'required',
            'client'            => 'required|exists:users,id'
        ], [
            'name.required'         => 'Ingrese un nombre para el Reporte',
            'upload.required'       => 'Debe seleccionar un archivo',
            'upload.mimes'          => 'El archivo seleccionado no es válido',
            'description.required'  => 'Debe escribir una descripción para el Reporte',
            'client.required'       => 'Debe seleccionar un cliente',
            'client.exists'         => 'El cliente seleccionado no existe'
        ]);
    }

    public function validator(array $data){
        return Validator::make($data, [
            'name'              => 'required',
            'upload'            => 'mimes:doc,docx,pdf',
            'description'       => 'required',
            'client'            => 'required|exists:users,id'
        ], [
            'name.required'         => 'Ingrese un nombre para el Reporte',
            'upload.mimes'          => 'El archivo seleccionado no es válido',
            'description.required'  => 'Debe escribir una descripción para el Reporte',
            'client.required'       => 'Debe seleccionar un cliente',
            'client.exists'         => 'El cliente seleccionado no existe'
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
        
        $users = User::where('role_id', 4)->get();
        $usersArray = array();
        $usersArray[''] = '';
        foreach ($users as $a_user) {
            $usersArray[$a_user->id] = $a_user->first_name." ".$a_user->last_name;
        }
        
        return view('reports.create', ['clients' => $usersArray]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $create_new_validator = $this->create_validator($request->all());

        if ($create_new_validator->fails()) {
            $this->throwValidationException(
                $request, $create_new_validator
                );
        } else {
            $user                   = \Auth::user();
            $report                 = new Report;
            $report->name           = $request->input('name');
            $report->description    = $request->input('description');
            $report->belongs_to     = $request->input('client');
            $report->uploaded_by    = $user->id;

            $file = NULL;
            // CHECK FOR REPORT FILE UPLOAD
            if(Input::file('upload') != NULL){

                $upload             = Input::file('upload');
                $filename           = str_replace(' ', '_', $report->name) .'.' . $upload->getClientOriginalExtension();
                $save_path          = '/users/id/' . $user->id . '/uploads/reports/';

                // MAKE USER FOLDER AND UPDATE PERMISSIONS
                // File::makeDirectory(storage_path(). $save_path, $mode = 0755, true, true);

                // SAVE FILE TO SERVER
                // Storage::put($save_path.$filename, $upload);

                // $upload->move(base_path().'/public/reports'.$save_path, $filename);
                $upload->move(storage_path().$save_path, $filename);

                // SAVE ROUTED PATH TO IMAGE TO DATABASE
                $file = '/files/users/' . $user->id . '/reports/' . $filename;
                $report->extension  = $upload->getClientOriginalExtension();
            }

            $report->storage = $file;

            $report->save();

            return redirect('report')->with('status', 'Reporte subido éxitosamente!');
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
        $report = Report::find($id);

        return view('reports.view', [
            'report'        => $report
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
        $user = \Auth::user();
        
        $users = User::where('role_id', 4)->get();
        $usersArray = array();
        $usersArray[''] = '';
        foreach ($users as $a_user) {
            $usersArray[$a_user->id] = $a_user->first_name." ".$a_user->last_name;
        }

        $report = Report::find($id);
        
        return view('reports.edit', [
            'report'    => $report,
            'clients'   => $usersArray]);
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
        $update_validator = $this->validator($request->all());

        if ($update_validator->fails()) {
            $this->throwValidationException(
                $request, $update_validator
                );
        } else {
            $user                   = \Auth::user();
            $report                 = Report::find($id);
            
            $report->description    = $request->input('description');
            $report->belongs_to     = $request->input('client');
            // $report->uploaded_by    = $user->id;

            $file = NULL;
            // CHECK FOR REPORT FILE UPLOAD
            if(Input::file('upload') != NULL){
                $report->name       = $request->input('name');

                $upload             = Input::file('upload');
                $filename           = str_replace(' ', '_', $report->name) .'.' . $upload->getClientOriginalExtension();
                $save_path          = '/users/id/' . $report->owner->id . '/uploads/reports/';

                // MAKE USER FOLDER AND UPDATE PERMISSIONS
                // File::makeDirectory(storage_path(). $save_path, $mode = 0755, true, true);

                // SAVE FILE TO SERVER
                // Storage::put($save_path.$filename, $upload);

                // $upload->move(base_path().'/public/reports'.$save_path, $filename);
                unlink(storage_path().$save_path.$report->name . '.' . $report->extension);
                $upload->move(storage_path().$save_path, $filename);

                // SAVE ROUTED PATH TO IMAGE TO DATABASE
                $file = '/files/users/' . $report->owner->id . '/reports/' . $filename;
                $report->storage    = $file;
                $report->extension  = $upload->getClientOriginalExtension();
            } else {
                if ($report->name != $request->input('name')) {

                    $save_path          = '\users\id\\' . $report->owner->id . '\uploads\reports\\';
                    rename(
                        storage_path(). $save_path. str_replace(' ', '_', $report->name) . '.' . $report->extension,
                        storage_path(). $save_path. str_replace(' ', '_', $request->input('name')) . '.' . $report->extension
                    );
                    $report->name       = $request->input('name');
                    $filename           = str_replace(' ', '_', $report->name) .'.' . $report->extension;
                    $file               = '/files/users/' . $report->owner->id . '/reports/' . $filename;
                    $report->storage    = $file;
                }
            }

            // $report->storage    = $file;

            $report->save();

            return redirect('report')->with('status', 'Reporte modificado éxitosamente!');
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
        // DELETE REPORT
        $report = Report::find($id);

        $save_path          = '\users\id\\' . $report->owner->id . '\uploads\reports\\';
        unlink(storage_path().$save_path.$report->name . '.' . $report->extension);

        $report->delete();

        return redirect('report')->with('status', 'Reporte eliminado éxitosamente!');
    }

    public function getReport($id, $report)
    {
        // return Image::make(storage_path() . '/users/id/' . $id . '/uploads/images/profile-pics/' . $image)->response();

        $file_url = storage_path() . '/users/id/' . $id . '/uploads/reports/' . $report;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);
    }
}
