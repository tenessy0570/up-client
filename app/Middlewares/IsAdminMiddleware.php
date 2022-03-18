<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class IsAdminMiddleware
{
    public function handle(Request $request)
    {
        // Перенаправляет на главную страницу, если не админ пытается выполнить админское действие
        $isAdmin = Auth::isAdmin();
        $urlsForAdmin = [
            '/createNewUser',
            '/createNewState',
            '/createNewDivision',
            '/deleteUser',
            '/deleteState',
            '/deleteDivision'
        ];
        $url = $request->url;

        if (in_array($url, $urlsForAdmin)) {
            if (!$isAdmin) {
                app()->route->redirect('/hello');
            }
        }
    }
}
