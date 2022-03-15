<?php

use Src\Route;

Route::add('index', [Controller\Site::class, 'index']);
Route::add('hello', [Controller\Site::class, 'hello']);
Route::add('signup', [Controller\Site::class, 'signup']);