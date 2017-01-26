<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Logic\User\UserRepository;
use App\Models\Profile;
use App\Models\User;

use Validator;
use Input;
use Image;
use File;

class ProfilesController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | User Profiles Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "View Profile" and "Edit Profile" pages.
    |
    */

    protected $auth;
    protected $userRepository;

    // RUN VIEW THROUGH AUTH MIDDLWARE via the CONSTRUCTOR
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function profile_validator(array $data)
    {
        return Validator::make($data, [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'bio'                   => '',
            'phone'                 => '',
            'skype_user'            => '',
            'user_profile_pic'      => 'image'
        ],[
            'first_name.required'       => 'Ingrese un nombre',
            'last_name.required'        => 'Ingrese un apellido',
            'user_profile_pic.image'    => 'El archivo debe ser una imagen'
        ]);
    }

    /**
     * /username
     *
     * @param $username
     * @return Response
     */
    public function show($username)
    {
        try {
            $user = $this->getUserByUsername($username);
        } catch (ModelNotFoundException $e) {
            return view('pages.status')
            ->with('error',\Lang::get('profile.notYourProfile'))
            ->with('error_title',\Lang::get('profile.notYourProfileTitle'));
        }
        return view('profiles.show')->withUser($user);
    }

    /**
     * Fetch user
     * (You can extract this to repository method)
     *
     * @param $username
     * @return mixed
     */
    public function getUserByUsername($username)
    {
        return User::with('profile')->wherename($username)->firstOrFail();
    }

    /**
     * /profiles/username/edit
     *
     * @param $username
     * @return mixed
     */
    public function edit($username)
    {
        try {
            $user = $this->getUserByUsername($username);
        } catch (ModelNotFoundException $e) {
            return view('pages.status')
            ->with('error',\Lang::get('profile.notYourProfile'))
            ->with('error_title',\Lang::get('profile.notYourProfileTitle'));
        }
        return view('profiles.edit')->withUser($user);
    }

    /**
     * Update a user's profile
     *
     * @param $username
     * @return mixed
     * @throws Laracasts\Validation\FormValidationException
     */
    public function update($username, Request $request)
    {

        $profile_validator = $this->profile_validator($request->all());

        if ($profile_validator->fails()) {

            $this->throwValidationException(
                $request, $profile_validator
                );
            return redirect('profile/'.$user->name.'/edit')->withErrors($validator)->withInput();
        }

        $user = $this->getUserByUsername($username);

        $user->first_name           = $request->input('first_name');
        $user->last_name            = $request->input('last_name');

        $user->save();

        $input = Input::only('bio',
            'phone',
            'skype_user',
            'profile_pic');

        // CHECK IF PROFILE EXISTS JUST IN CASE
        if ($user->profile == null) {
            $profile = new Profile;
            $user->profile()->save($profile);
        } else {
            $profile = $user->profile;
        }

        $profile->bio = $request->input('bio');
        $profile->phone = $request->input('phone');
        $profile->skype_user = $request->input('skype_user');

        $pic = $profile->profile_pic;
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

        $profile->profile_pic = $pic;
        $user->profile()->save($profile);
        
        return redirect('profile/'.$user->name)->with('status', 'Perfil actualizado!');
    }

    // FUNCTON TO RETURN USER PROFILE BACKGROUND IMAGE
    public function userProfilePicImage($id, $image)
    {
        return Image::make(storage_path() . '/users/id/' . $id . '/uploads/images/profile-pics/' . $image)->response();
    }

}

