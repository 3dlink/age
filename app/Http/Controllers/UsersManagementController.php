<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Models\Profile;
use App\Http\Requests;
use App\Models\User;
use App\Models\Role;

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

class UsersManagementController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Users Management Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "Show Users", "Edit Users",
	| and "Create User" pages. This class also
    | has the method to delete a user.
    |
	*/

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

	/**
	 * Show the Users Management Main Page to the Admin.
	 *
	 * @return Response
	 */
	public function showUsersMainPanel()
	{
        $user                   = \Auth::user();
        $users 			        = User::all();
        $total_users 	        = \DB::table('users')->count();

        $total_users_confirmed  = \DB::table('users')->count();
        $total_users_confirmed  = \DB::table('users')->where('active', '1')->count();
        $total_users_locked     = \DB::table('users')->where('resent', '>', 3)->count();

        $total_users_new        = \DB::table('users')->where('active', '0')->count();

        return view('admin.show-users', [
          'user' 			        => $user,
          'users'                   => $users,
          'total_users'             => $total_users
          ]
          );
    }

    /**
     * Get a validator for an incoming update user request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name'          	        => 'required|max:255',
            'email'         	        => 'required|email|max:255',
            'bio'                       => '',
            'phone'                     => '',
            'skype_user'                => '',
            'user_profile_pic'          => 'image'
        ], [
            'name.required'             => 'Ingrese un nombre de usuario',
            'email.required'            => 'Ingrese un correo electrónico',
            'email.email'               => 'Debe ingresar un correo válido',
            'user_profile_pic.image'    => 'El archivo debe ser una imagen'
        ]);
    }

    /**
     * Get a validator for an incoming create user request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function create_new_validator(array $data)
    {
        return Validator::make($data, [
            'name'                  => 'required|alpha_num|min:5|max:255|unique:users',
            'email'                 => 'required|email|max:255|unique:users',
            'first_name'            => 'required|max:255',
            'last_name'             => 'required|max:255',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
            'user_level'            => 'required',
            'bio'                   => '',
            'phone'                 => '',
            'skype_user'            => '',
            'user_profile_pic'      => 'image'
        ], [
            'name.required'                     => 'Ingrese un nombre de usuario',
            'name.max'                          => 'La longitud del nombre de usuario no puede ser mayor a 255 carácteres',
            'name.unique'                       => 'El nombre de usuario ya existe',
            'first_name.required'               => 'Ingrese un nombre',
            'last_name.required'                => 'Ingrese un apellido',
            'email.required'                    => 'Ingrese un correo electrónico',
            'password.required'                 => 'Ingrese una contraseña',
            'password.min'                      => 'Su contraseña debe tener al menos 6 carácteres',
            'password_confirmation.required'    => 'Confirme su contraseña',
            'password.same'                     => 'Sus contraseñas deben coincidir',
            'password_confirmation.same'        => 'Sus contraseñas deben coincidir',
            'user_profile_pic.image'            => 'El archivo debe ser una imagen',
            'user_level.required'               => 'Debe seleccionar un nivel de acceso',
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

        // GET THE USER
        $user               = User::find($id);
        $userRole           = $user->hasRole('usuario');
        $analystRole        = $user->hasRole('analista');
        $supervisorRole     = $user->hasRole('supervisor');
        $adminRole          = $user->hasRole('super administrador');

        $access;

        if($userRole)
        {
            $access = 'User';
        } elseif ($analystRole) {
            $access = 'Analyst';
        } elseif ($supervisorRole) {
            $access = 'Supervisor';
        } elseif ($adminRole) {
            $access = 'Administrador';
        } else {
            $access = 'None';
        }

        return view('admin.edit-user', [
            'user'                      => $user,
            'access'                    => $access,
            ]
            )->with('status', 'Usuario actualizado éxitosamente!');

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

        $rules = array(
            'name'              => 'required',
            'email'             => 'required|email',
            );

        $validator = $this->validator($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
                );
        } else {
            $user 				        = User::find($id);
            $user->name                 = $request->input('name');
            $user->first_name           = $request->input('first_name');
            $user->last_name            = $request->input('last_name');
            $user->email                = $request->input('email');

            $user->role_id = $request->input('user_level');

            // SAVE USER CORE SETTINGS
            $user->save();

            return redirect('users/' . $user->id . '/')->with('status', 'Usuario actualizado éxitosamente!');

        }
    }

    /**
     * Show the form for creating a new User
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create-user');
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
        }
        else
        {

            $activation_code        = str_random(60) . $request->input('email');
            $user                   = new User;
            $user->email            = $request->input('email');
            $user->name             = $request->input('name');
            $user->first_name       = $request->input('first_name');
            $user->last_name        = $request->input('last_name');
            $userAccessLevel        = $request->input('user_level');
            $user->password         = bcrypt($request->input('password'));

            // GET ACTIVATION CODE
            $user->activation_code  = $activation_code;
            $user->active           = '1';

            // GET IP ADDRESS
            $userIpAddress          = new CaptureIp;
            $user->admin_ip_address = $userIpAddress->getClientIp();

            // SAVE THE USER
            $user->save();

            $role = Role::find($userAccessLevel);
            $role->users()->save($user);

            $pic = NULL;
            // CHECK FOR USER PROFILE IMAGE FILE UPLOAD
            if(Input::file('user_profile_pic') != NULL){

                $user_profile_pic    = Input::file('user_profile_pic');
                $filename           = 'user-pic.' . $user_profile_pic->getClientOriginalExtension();
                $save_path          = storage_path() . '/users/id/' . $user->id . '/uploads/images/profile-pics/';

            // MAKE USER FOLDER AND UPDATE PERMISSIONS
                File::makeDirectory($save_path, $mode = 0755, true, true);

            // SAVE FILE TO SERVER
                Image::make($user_profile_pic)->save($save_path . $filename);

            // SAVE ROUTED PATH TO IMAGE TO DATABASE
                $pic = '/images/profile/' . $user->id . '/pics/' . $filename;
            }

            // CREATE PROFILE LINK TO TABLE
            $profile = new Profile;

            $profile->bio = $request->input('bio');
            $profile->phone = $request->input('phone');
            $profile->skype_user = $request->input('skype_user');
            $profile->profile_pic = $pic;
            $user->profile()->save($profile);

            // THE SUCCESSFUL RETURN
            return redirect('users')->with('status', 'Usuario creado éxitosamente!');
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
    	// GET USER
        $user = User::find($id);

        return view('admin.show-user')->withUser($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DELETE USER
        $user = User::find($id);
        $user->delete();

        return redirect('users')->with('status', 'Usuario eliminado éxitosamente!');
    }

    /**
     * Return count of ALL USERS using View::Composer
     *
     * @param  \App\Providers\ComposerServiceProvider.php
     * @param  obj $view
     * @return \Illuminate\View\View
     */
    public function getTotalUsers(View $view)
    {
        $users                  = \DB::table('users')->get();
        $total_users            = \DB::table('users')->count();
        $view->with('totalUsers', $total_users);
    }

    // FUNCTON TO RETURN USER PROFILE BACKGROUND IMAGE
    public function userProfilePicImage($id, $image)
    {
        return Image::make(storage_path() . '/users/id/' . $id . '/uploads/images/profile-pics/' . $image)->response();
    }

    public function getAssignedAnalystsView()
    {
        if (\Auth::user()->role_id == 4) {
            $user = \Auth::user();
            $analysts = \Auth::user()->analysts;
            return view('admin.show-users', [
              'user'                    => $user,
              'users'                   => $analysts,
              'total_users'             => 1
              ]
              );
        } else {
            $analysts = User::wherein('role_id', [2,3])->get();
            $clients = [];
            foreach ($analysts as $a_analyst) {
                foreach ($a_analyst->clients as $client) {
                    array_push($clients, $client->id);
                }
            }

            $clients = User::wherein('id', array_unique($clients))->get();
            // dd($clients);
            $total_clients = $clients->count();
        }

        // dd($clients->analysts);
        return view('admin.assignments', [
            'clients'       => $clients,
            'total_clients' => $total_clients
            ]);
    }

    public function getAssignAnalystsView()
    {
        $clients = User::where('role_id', 4)->get();
        $usersArray = array();
        $usersArray[''] = '';
        foreach ($clients as $a_user) {
            if ($a_user->analysts()->count() == 0) {
                $usersArray[$a_user->id] = $a_user->first_name." ".$a_user->last_name;
            }        
        }
        $analysts = User::wherein('role_id', [2,3])->get();

        return view('admin.assign', [
            'clients'   => $usersArray,
            'analysts'  => $analysts
            ]);
    }

    public function assignmentValidator(array $data)
    {
        return Validator::make($data, [
            'client'        => 'required|exists:users,id'
            ]);
    }

    public function assignAnalysts(Request $request)
    {
        $assignmentValidator = $this->assignmentValidator($request->all());

        if ($assignmentValidator->fails()) {
            $this->throwValidationException(
                $request, $assignmentValidator
                );
        } else {
            $client = User::find($request->input('client'));

            $analysts = [];

            $array = array_slice($request->input(), 2);

            foreach ($array as $analyst => $id) {
                array_push($analysts, $id);
            }

            $client->analysts()->attach($analysts);
        }

        return redirect('assignments')->with('status', 'Analistas asignados éxitosamente!');
    }

    public function unassignAnalysts($id)
    {
        $client = User::find($id);
        $client->analysts()->detach();

        return redirect('assignments')->with('status', 'Asignación eliminada!');
    }

    public function getEditAnalystsView($id)
    {
        $client = User::find($id);
        $analysts = User::wherein('role_id', [2,3])->get();

        $clientsArray[$client->id] = $client->first_name." ".$client->last_name;

        return view('admin.reassign', [
            'client'        => $client,
            'clients'       => $clientsArray,
            'analysts'      => $analysts
            ]);
    }

    public function updateAnalystsAssignment($id, Request $request)
    {
        $client = User::find($id);

        $analysts = [];

        $array = array_slice($request->input(), 3);

        foreach ($array as $analyst => $id) {
            array_push($analysts, $id);
        }
        $client->analysts()->detach();
        $client->analysts()->attach($analysts);

        return redirect('assignments')->with('status', 'Asignación actualizada éxitosamente!');
    }
}
