<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity' => \Model\User::class,
    //Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'isadmin' => \Middlewares\IsAdminMiddleware::class,
    ],
    'routeAppMiddleware' => [
        'trim' => \Middlewares\TrimMiddleware::class,
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'select' => \Validators\SelectValidator::class,
        'password' => \Validators\PasswordValidator::class,
        'login' => \Validators\LoginValidator::class,
    ]
];
