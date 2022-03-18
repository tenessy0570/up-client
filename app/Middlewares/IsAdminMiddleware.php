<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class IsAdminMiddleware
{
    public function handle(Request $request)
    {
        $isAdmin = Auth::isAdmin();
        // Перенаправляет на главную страницу, если не админ пытается выполнить админское действие
        if (!$isAdmin) {
            app()->route->redirect('/hello');
        }
    }
}
