<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use App\Logic\User\UserRepository;
use App\Logic\User\CaptureIp;
use App\Models\User;
use App\Models\Role;
use App\Models\Profile;
use App\Traits\CaptchaTrait;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/


	use AuthenticatesAndRegistersUsers
    {
        getLogout as authLogout;
    }
	use CaptchaTrait;
	use ThrottlesLogins;

    protected $auth;
    protected $userRepository;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, UserRepository $userRepository)
	{

		$this->middleware('guest',
			['except' =>
				['getLogout', 'resendEmail', 'activateAccount']]);

        $this->auth = $auth;
        $this->userRepository = $userRepository;

	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' 								=> 'required|max:255|unique:users',
			'empresa'							=> 'required|max:255|unique:users',
			'first_name' 						=> 'required|max:255',
			'last_name' 						=> 'required|max:255',
			'email' 							=> 'required|email|max:255|unique:users',
            'password'              			=> 'required|min:6|confirmed',
            'password_confirmation' 			=> 'required|same:password',
		],[
			'name.required'						=> 'Ingrese un nombre de usuario',
			'name.max'							=> 'La longitud del nombre de usuario no puede ser mayor a 255 carácteres',
			'name.unique'						=> 'El nombre de usuario ya existe',
			'first_name.required'				=> 'Ingrese un nombre',
			'last_name.required'				=> 'Ingrese un apellido',
			'email.required'					=> 'Ingrese un correo electrónico',
			'password.required'					=> 'Ingrese una contraseña',
			'password.min'						=> 'Su contraseña debe tener al menos 6 carácteres',
			'password_confirmation.required'	=> 'Confirme su contraseña',
			'password_confirmation.same'		=> 'Sus contraseñas deben coincidir',
			'empresa.unique'                    => 'Esta empresa ya existe',
			'empresa.required'                  => 'Ingrese el nombre de su empresa'
		]);
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{

		// DISABLED WHILE TESTING - Already disabled :)
	    // if($this->captchaCheck() == false)
	    // {
	    //     return redirect()->back()->withErrors(['Sorry, Wrong Captcha'])->withInput();
	    // }

		$validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

		$activation_code 			= str_random(60) . $request->input('email');
		$user 						= new User;
		$user->name 				= $request->input('name');
		$user->empresa 				= $request->input('empresa');
		$user->first_name 			= $request->input('first_name');
		$user->last_name 			= $request->input('last_name');
		$user->email 				= $request->input('email');
		$user->password 			= bcrypt($request->input('password'));
		$user->activation_code 		= $activation_code;

		// GET IP ADDRESS
		$userIpAddress 				= new CaptureIp;
		$user->signup_ip_address	= $userIpAddress->getClientIp();

		if ($user->save()) {

			$this->sendEmail($user);
	        // $user_role = Role::whereName('usuario')->first();
	        $role = Role::find(4);
	        $role->users()->save($user);

            $profile = new Profile;
            $user->profile()->save($profile);

			return view('auth.activateAccount')->with('email', $request->input('email'));

		} else {

			\Session::flash('message', \Lang::get('notCreated') );
		}

	}

	public function sendEmail(User $user)
	{
		$data = array(
			'name' => $user->name,
			'code' => $user->activation_code,
		);

		\Mail::queue('emails.activateAccount', $data, function($message) use ($user) {
			$message->subject( \Lang::get('auth.pleaseActivate') );
			$message->to($user->email);
		});
	}

	public function resendEmail()
	{
		$user = \Auth::user();
		if( $user->resent >= 3 )
		{
			return view('auth.tooManyEmails')->with('email', $user->email);
		} else {
			$user->resent = $user->resent + 1;
			$user->save();
			$this->sendEmail($user);
			return view('auth.activateAccount')->with('email', $user->email);
		}
	}

	public function activateAccount($code, User $user)
	{

		if($user->accountIsActive($code)) {

			\Session::flash('message', \Lang::get('auth.successActivated') );
			return redirect('home');
		}

		\Session::flash('message', \Lang::get('auth.unsuccessful') );
		return redirect('home');

	}
}

