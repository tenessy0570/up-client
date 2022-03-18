<?php

use Controller\Site;
use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');

// Unauthenticated actions
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);

// Authenticated actions
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add("GET", '/getAverageAge', [Controller\Site::class, 'getAverageAge']);
Route::add(["GET", "POST"], '/getDivisionStaff', [Controller\Site::class, 'getDivisionStaff']);
Route::add(["GET", "POST"], '/getStateStaff', [Controller\Site::class, 'getStateStaff']);

// Admin actions
Route::add(['GET', 'POST'], '/createNewUser', [Controller\Site::class, 'createNewUser'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/createNewState', [Site::class, 'createnewState'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/createNewDivision', [Site::class, 'createNewDivision'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/deleteUser', [Site::class, 'deleteUser'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/deleteState', [Site::class, 'deleteState'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();

Route::add(['GET', 'POST'], '/deleteDivision', [Site::class, 'deleteDivision'])
    ->middleware('isadmin')
    ->setPrefix('admin')
    ->save();
