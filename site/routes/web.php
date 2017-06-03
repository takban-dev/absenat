<?php

Route::get('/', function () {
    return view('welcome', ['tab' => 'login']);
})->name('home');

/* self pages */
Route::get('/dashboard', 'HomeController@dashboard')->middleware('auth');
Route::get('/profile', function () {
    return view('welcome');
});

/* ===================================================================
                         management pages
====================================================================*/

/* ====================  admin panels  =============================*/

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'check-admin']], function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    
    /* users list */
    Route::get('/users', 'AdminUsersController@list');
    /* single user page for editing or viewing */
    Route::get ('/user/{userId}/{watching?}/{page?}/{size?}', 'AdminUsersController@editGet')->where('unitId', '[0-9]+');
    Route::post('/user/{userId}/{watching?}/{page?}/{size?}', 'AdminUsersController@editPost')->where('unitId', '[0-9]+');
    /* new user page */
    Route::get('/user-new', 'AdminUsersController@newGet');
    Route::post('/user-new', 'AdminUsersController@newPost');


    /* units list */
    Route::get('/units/{page?}/{size?}', 'AdminUnitsController@list');
    /* single unit page for editing or viewing */
    Route::get ('/unit/{unitId}/{page?}/{size?}', 'AdminUnitsController@editGet')->where('unitId', '[0-9]+');
    Route::post('/unit/{unitId}/{page?}/{size?}', 'AdminUnitsController@editPost')->where('unitId', '[0-9]+');
    /* new unit page */
    Route::get('/unit-new', 'AdminUnitsController@newGet');
    Route::post('/unit-new', 'AdminUnitsController@newPost');
    /* remove unit */
    Route::get('/unit-remove/{id}', 'AdminUnitsController@remove');

    /* employees list */
    Route::get('/employees/{page?}/{size?}', 'AdminEmployeesController@list');
    /* single employees page for editing or viewing */
    Route::get('/employee/{employeeId}/{page?}/{size?}', 'AdminEmployeesController@editGet')->where('employeeId', '[0-9]+');
    Route::post('/employee/{employeeId}/{page?}/{size?}', 'AdminEmployeesController@editPost')->where('employeeId', '[0-9]+');
    /* new employee page */
    Route::get('/employee-new/{unitId?}', 'AdminEmployeesController@newGet');
    Route::post('/employee-new', 'AdminEmployeesController@newPost');

    /* reporets page */
    Route::get('/reports', function () {
        return 'reporsts page for admin';
    });

});

/* ====================  regular panels  =============================*/

Route::group(['namespace' => 'RegularMember', 'middleware' => 'auth'], function () {
    // Controllers Within The "App\Http\Controllers\RegularMember" Namespace

    /* units list */
    Route::get('/units/{page?}/{size?}', 'NormalUnitsController@list');
    /* single unit page for editing or viewing */
    Route::get ('/unit/{unitId}/{page?}/{size?}', 'NormalUnitsController@editGet')->where('unitId', '[0-9]+');
    Route::post('/unit/{unitId}/{page?}/{size?}', 'NormalUnitsController@editPost')->where('unitId', '[0-9]+');
    /* new unit page */
    Route::get('/unit-new', 'NormalUnitsController@newGet');
    Route::post('/unit-new', 'NormalUnitsController@newPost');
    /* remove unit */
    Route::get('/unit-remove/{id}', 'NormalUnitsController@remove');


    /* employees list */
    Route::get('/employees', function () {
        return 'employees list for member';
    });
    /* single employees page for editing or viewing */
    Route::get('/employee/{employeeId}', function ($employeeId) {
        return "employee page id: $employeeId for member";
    })->where('employeeId', '[0-9]+');
    /* new employee page */
    Route::get('/employee-new', function () {
        return 'new employee page for member';
    });

});

Route::post('/login', 'HomeController@login');
Route::post('/register', 'HomeController@register');
Route::get('/logout', 'HomeController@logout');