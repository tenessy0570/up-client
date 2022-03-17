<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class IsAdminMiddleware
{
    public function handle(Request $request)
    {
        $isAdmin = Auth::isAdmin();
        $urlsForAdmin = [
            '/createNewUser',
            '/createNewState',
            '/createNewDivision',
            '/deleteUser',
            '/deleteState',
            '/deleteDivision'
        ];
        $url = $_SERVER['REQUEST_URI'];

        if (in_array($url, $urlsForAdmin)) {
            if (!$isAdmin) {
                app()->route->redirect('/hello');
            }
        }
    }
}
