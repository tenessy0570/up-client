<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AuthMiddleware
{
    public function handle(Request $request)
    {
        $isAdmin = Auth::isAdmin();
        $urlsForAdmin = [];
        $url = $_SERVER['REQUEST_URI'];

        if (in_array($url, $urlsForAdmin)) {
            if (!$isAdmin) {
                app()->route->redirect('/hello');
            }
        }
    }
}
