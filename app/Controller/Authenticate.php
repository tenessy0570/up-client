<?php

namespace Controller;

use Src\View;
use Src\Auth\Auth;
use Src\Request;
use Model\User;
use Model\State;
use Src\Validator\Validator;


class Authenticate
{
    public function signup(Request $request): string
    {
        if ($request->method === "POST") {
            $post = $request->post;
            $states = State::all();

            if ($post['password'] !== $post['password2']) return new View('site.signup', ['error' => 'Пароли не совпадают <br>', 'states' => $states]);

            $validator = new Validator($request->all(), [
                'first_name' => ['required'],
                'login' => ['required', 'unique:users,login', 'login'],
                'password' => ['required', 'password'],
                'last_name' => ['required'],
                'middle_name' => ['required'],
                'post' => ['required'],
                'birth_date' => ['required'],
                'home_address' => ['required'],
                'state' => ['select', 'required'],
                'gender' => ['select', 'required'],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if ($validator->fails()) {
                return new View(
                    'site.signup',
                    [
                        'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                        'states' => $states
                    ]
                );
            }

            if (User::create($request->all())) {
                app()->route->redirect('/hello');
            }
        }

        $states = State::all();
        return new View('site.signup', ['states' => $states]);
    }
    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }
}
