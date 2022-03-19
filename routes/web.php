<?php

use Src\Route;



// Unauthenticated actions
Route::add(['GET', 'POST'], '/signup', [Controller\Authenticate::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Authenticate::class, 'login']);

// Authenticated actions
Route::add('GET', '/logout', [Controller\AuthorizedActions::class, 'logout']);
Route::add("GET", '/getAverageAge', [Controller\AuthorizedActions::class, 'getAverageAge']);
Route::add(["GET", "POST"], '/getDivisionStaff', [Controller\AuthorizedActions::class, 'getDivisionStaff']);
Route::add(["GET", "POST"], '/getStateStaff', [Controller\AuthorizedActions::class, 'getStateStaff']);
Route::add('GET', '/hello', [Controller\AuthorizedActions::class, 'hello'])
    ->middleware('auth');

// Admin actions
Route::add(['GET', 'POST'], '/createNewUser', [Controller\Admin::class, 'createNewUser'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/createNewState', [Controller\Admin::class, 'createnewState'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/createNewDivision', [Controller\Admin::class, 'createNewDivision'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/deleteUser', [Controller\Admin::class, 'deleteUser'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/deleteState', [Controller\Admin::class, 'deleteState'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/deleteDivision', [Controller\Admin::class, 'deleteDivision'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();
