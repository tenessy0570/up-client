<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;
use Src\Settings;

class IsAdminMiddleware
{
    public function handle(Request $request)
    {
        // Перенаправляет на главную страницу, если не админ пытается выполнить админское действие
        $isAdmin = Auth::isAdmin();
        $url = $request->url;

        $allUris = Settings::getUris();
        $urlsForAdmin = [];

        foreach ($allUris as $uri) {
            $explodedUri = explode('.', $uri);
            if ($explodedUri[0] === 'admin') array_push($urlsForAdmin, $explodedUri[1]);
        }


        if (in_array($url, $urlsForAdmin)) {
            if (!$isAdmin) {
                app()->route->redirect('/hello');
            }
        }
    }
}
