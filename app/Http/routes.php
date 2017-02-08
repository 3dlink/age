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

Route::get('files/users/{id}/reports/{report}', [
	'uses'		=> 'ReportController@getReport'
]);

Route::get('files/users/{user}/requirements/{id}/{file}', [
	'uses'		=> 'RequirementController@getRequirementFile'
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

	Route::resource('report', 'ReportController');
	Route::resource('requirement', 'RequirementController');
	Route::resource('task', 'TaskController');

	Route::get('/assignments', [
		'as'		=> 'assignments',
		'uses'		=>	'UsersManagementController@getAssignedAnalystsView'
	]);

	Route::get('analyst', [
		'as'		=> 'analysts',
		'uses'		=> 'TaskController@getAssignedAnalystsView'
	]);

	Route::get('analyst/{year}/{month}', [
		'as'		=> 'analyst.tasks',
		'uses'		=> 'TaskController@getAnalystTasks'
	]);

	Route::get('analyst/pdf/{year}/{month}', [
		'as'		=> 'analyst.pdf',
		'uses'		=> 'TaskController@getPDF'
	]);

	Route::get('analyst/task/{year}/{month}/{task}', [
		'as'		=> 'analyst.task',
		'uses'		=> 'TaskController@showAnalyst'
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

Route::group(['middleware' 	=> 	'analyst'], function(){
	
});

Route::group(['middleware'	=>	'supervisor'], function(){
	Route::resource('requirement/assign', 'AssignRequirementController');

	Route::get('requirement/assign/create/{id}', [
		'as'		=> 'requirement/assign.new',
		'uses'		=> 'AssignRequirementController@create'
	]);

	Route::get('/assign', [
		'as'		=> 'analyst.assign',
		'uses'		=> 'UsersManagementController@getAssignAnalystsView'
	]);

	Route::delete('/assign/{client}', [
		'as'		=> 'analyst.unassign',
		'uses'		=> 'UsersManagementController@unassignAnalysts'
	]);

	Route::get('/assign/{client}/edit', [
		'as'		=> 'analyst.edit',
		'uses'		=>	'UsersManagementController@getEditAnalystsView'
	]);

	Route::put('/assign/{client}', [
		'as'		=> 'analyst.update',
		'uses'		=>	'UsersManagementController@updateAnalystsAssignment'
	]);

	Route::post('/assign', [
		'as'		=> 'analyst.assignment',
		'uses'		=>	'UsersManagementController@assignAnalysts'
	]);
});