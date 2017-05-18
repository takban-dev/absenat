<?php

Route::get('/', function () {
    return view('welcome');
});

/* self pages */
Route::get('/dashboard', function () {
    return view('welcome');
});

Route::get('/profile', function () {
    return view('welcome');
});

/* ===================================================================
                         management pages
====================================================================*/

/* ====================  admin panels  =============================*/

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    
        /* users list */
    Route::get('/users', function () {
        return 'users list for admin';
    });
    /* single user page for editing or viewing */
    Route::get('/user/{userId}', function ($userId) {
        return "user page id: $userId for admin";
    })->where('userId', '[0-9]+');
    /* new user page */
    Route::get('/user-new', function () {
        return 'new user page for admin';
    });

    /* units list */
    Route::get('/units', function () {
        return 'units list for admin';
    });
    /* single unit page for editing or viewing */
    Route::get('/unit/{unitId}', function ($unitId) {
        return "unit page id: $unitId for admin";
    })->where('unitId', '[0-9]+');
    /* new unit page */
    Route::get('/unit-new', function () {
        return 'new unit page for admin';
    });


    /* employees list */
    Route::get('/employees', function () {
        return 'employees list for admin';
    });
    /* single employees page for editing or viewing */
    Route::get('/employee/{employeeId}', function ($employeeId) {
        return "employee page id: $employeeId for admin";
    })->where('employeeId', '[0-9]+');
    /* new employee page */
    Route::get('/employee-new', function () {
        return 'new employee page for admin';
    });

    /* reporets page */
    Route::get('/reports', function () {
        return 'reporsts page for admin';
    });

});

/* ====================  regular panels  =============================*/

Route::group(['namespace' => 'RegularMember'], function () {
    // Controllers Within The "App\Http\Controllers\RegularMember" Namespace

    /* units list */
    Route::get('/units', function () {
        return 'units list for member';
    });
    /* single unit page for editing or viewing */
    Route::get('/unit/{unitId}', function ($unitId) {
        return "unit page id: $unitId for member";
    })->where('unitId', '[0-9]+');
    /* new unit page */
    Route::get('/unit-new', function () {
        return 'new unit page for member';
    });


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

