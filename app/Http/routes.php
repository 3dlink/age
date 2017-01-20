<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
| http://laravel.com/docs/5.1/authentication
| http://laravel.com/docs/5.1/authorization
| http://laravel.com/docs/5.1/routing
| http://laravel.com/docs/5.0/schema
| http://socialiteproviders.github.io/
|
*/

// PAGE ROUTE ALIASES
Route::get('home', function () {
    return redirect('/');
});
Route::get('app', function () {
    return redirect('/');
});
Route::get('dashboard', function () {
    return redirect('/');
});

// ALL AUTHENTICATION ROUTES - HANDLED IN THE CONTROLLERS
Route::controllers([
	'auth' 		=> 'Auth\AuthController',
	'password' 	=> 'Auth\PasswordController',
]);

// REGISTRATION EMAIL CONFIRMATION ROUTES
Route::get('/resendEmail', 'Auth\AuthController@resendEmail');
Route::get('/activate/{code}', 'Auth\AuthController@activateAccount');

// AUTHENTICATION ALIASES/REDIRECTS
Route::get('login', function () {
    return redirect('auth/login');
});
Route::get('logout', function () {
    return redirect('auth/logout');
});
Route::get('register', function () {
    return redirect('auth/register');
});
Route::get('reset', function () {
    return redirect('password/email');
});

// ROUTE FOR USER PROFILE IMAGES
Route::get('images/profile/{id}/pics/{image}', [
	'uses' 		=> 'ProfilesController@userProfilePicImage'
]);

// USER PAGE ROUTES - RUNNING THROUGH AUTH MIDDLEWARE
Route::group(['middleware' => 'auth'], function () {

	// HOMEPAGE ROUTE
	Route::get('/', [
	    'as' 		=> 'user',
	    'uses' 		=> 'UserController@index'
	]);

	// INCEPTIONED MIDDLEWARE TO CHECK TO ALLOW ACCESS TO CURRENT USER ONLY
	Route::group(['middleware'=> 'currentUser'], function () {
			Route::resource(
				'profile',
				'ProfilesController', [
					'only' 	=> [
						'show',
						'edit',
						'update'
					]
				]
			);
	});
	Route::get('profile/{username}', [
		'as' 		=> 'profile.show',
		'uses' 		=> 'ProfilesController@show'
	]);

	Route::get('profile/{username}/edit', [
		'as' 		=> 'profile.edit',
		'uses' 		=> 'ProfilesController@edit'
	]);

});

// ADMINISTRATOR ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH ADMINISTRATOR MIDDLEWARE
Route::group(['middleware' => 'administrator'], function () {

	// SHOW ALL USERS PAGE ROUTE
	Route::resource('users', 'UsersManagementController');
	Route::resource('subject', 'SubjectController');
	Route::get('users', [
		'as' 			=> '{username}',
		'uses' 			=> 'UsersManagementController@showUsersMainPanel'
	]);

});

Route::group(['middleware' => 'analyst'], function(){
	Route::resource('task', 'TaskController');
});

Route::resource('report', 'ReportController');

// // EDITOR ACCESS LEVEL PAGE ROUTES - RUNNING THROUGH EDITOR MIDDLEWARE
// Route::group(['middleware' => 'editor'], function () {

// 	//TEST ROUTE ONLY
// 	Route::get('editor', function () {
// 	    echo 'Welcome to your EDITOR page '. Auth::user()->email .'.';
// 	});

// });

//***************************************************************************************//
//***************************** USER ROUTING EXAMPLES BELOW *****************************//
//***************************************************************************************//

// //** OPTION - ALL FOLLOWING ROUTES RUN THROUGH AUTHETICATION VIA MIDDLEWARE **//
// Route::group(['middleware' => 'auth'], function () {

// 	// OPTION - GO DIRECTLY TO TEMPLATE
// 	Route::get('/', function () {
// 	    return view('pages.home');
// 	});

// 	// OPTION - USE CONTROLLER
// 	Route::get('/', [
// 	    'as' 			=> 'user',
// 	    'uses' 			=> 'UsersController@index'
// 	]);

// });

// //** OPTION - SINGLE ROUTE USING A CONTROLLER AND AUTHENTICATION VIA MIDDLEWARE **//
// Route::get('/', [
//     'middleware' 	=> 'auth',
//     'as' 			=> 'user',
//     'uses' 			=> 'UsersController@index'
// ]);