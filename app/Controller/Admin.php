<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\State;
use Model\Division;
use Model\Company;
use Src\Validator\Validator;


class Admin
{   
    protected static $view;
    public function __construct()
    {
        self::$view = new View();
    }

    public function createNewUser(Request $request): string
    {
        $states = State::all();
        if ($request->method === "GET") return (new View)->render('site.create_new_user', ['states' => $states]);
        $post = $request->post;

        $validator = new Validator($request->all(), [
            'login' => ['unique:users,login'],
            'state' => ['select', 'required']
        ], [
            'unique' => 'Поле :field должно быть уникально'
        ]);

        if ($validator->fails()) {
            return self::$view->render(
                'site.create_new_user',
                [
                    'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'states' => $states
                ]
            );
        }

        if (User::create($request->all())) {
            return self::$view->render('site.create_new_user', ['states' => $states, 'error' => 'Успешно создан юзер с логином ' . $post['login']]);
        }
    }

    public function createNewState(Request $request): string
    {
        $divisions = Division::all();
        if ($request->method === "GET") return (new View)->render('site.create_new_state', ['divisions' => $divisions]);

        $post = $request->post;

        $divisionId = $post['division'];
        $allDivisionStates = State::where('division', $divisionId)->get();

        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'division' => ['select', 'required']
        ], [
            'required' => 'Поле :field обязательно'
        ]);

        if ($validator->fails()) {
            return self::$view->render(
                'site.create_new_state',
                [
                    'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'divisions' => $divisions
                ]
            );
        }

        $error = '';
        foreach ($allDivisionStates as $state) {
            if ($state->name === $post['name']) {
                $error = $error . "В подразделении уже есть штат с таким названием";
                break;
            }
        }

        if (!empty($error)) return new View('site.create_new_state', ['error' => $error, 'divisions' => $divisions]);

        if (State::create($request->all())) {
            return self::$view->render('site.create_new_state', ['error' => 'Штат успешно создан']);
        }

        return self::$view->render('site.create_new_state', ['error' => 'Произошла ошибка']);
    }

    public function createNewDivision(Request $request)
    {
        $companies = Company::all();
        if ($request->method === 'GET') return self::$view->render('site.create_new_division', ['companies' => $companies]);

        $post = $request->post;

        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'company' => ['select', 'required']
        ], [
            'required' => 'Поле :field обязательно'
        ]);

        if ($validator->fails()) {
            return self::$view->render(
                'site.create_new_division',
                [
                    'error' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'companies' => $companies
                ]
            );
        }

        $error = '';
        $divisionsWithSameName = Division::where(['name' => $post['name'], 'company' => $post['company']])->get();
        foreach ($divisionsWithSameName as $division) {
            if ($division->type === $post['type']) {
                $error = $error . 'Подразделение такого типа уже существует в компании';
                return self::$view->render('site.create_new_division', ['companies' => $companies, 'error' => $error]);
            }
        }

        if (Division::create($request->all())) {
            return self::$view->render('site.create_new_division', ['companies' => $companies, 'error' => 'Успешно создано']);
        } else {
            // handle error
        }
    }

    public function deleteUser(Request $request): string
    {
        $users = User::where('id', '!=', $_SESSION['id'])->get();

        if ($request->method === 'GET') return self::$view->render('site.delete_user', ['users' => $users]);

        $post = $request->post;

        if ($post['id'] === 'fake') return self::$view->render('site.delete_user', ['users' => $users, 'message' => 'Выберите пользователя']);

        $user = User::where('id', $post['id'])->first();

        if ($user->delete()) {
            $users = User::where('id', '!=', $_SESSION['id'])->get();
            return self::$view->render('site.delete_user', ['users' => $users, 'message' => 'Удалён успешно']);
        }
    }

    public function deleteState(Request $request): string
    {
        $states = State::all();
        if ($request->method === 'GET') return self::$view->render('site.delete_state', ['states' => $states]);

        $post = $request->post;

        if ($post['id'] === 'fake') return self::$view->render('site.delete_state', ['states' => $states, 'message' => 'Выберите штат']);

        $state = State::where('id', $post['id'])->first();

        if ($state->delete()) {
            $states = State::all();
            return self::$view->render('site.delete_state', ['states' => $states, 'message' => 'Удалён успешно']);
        }
    }

    public function deleteDivision(Request $request): string
    {
        $divisions = Division::all();
        if ($request->method === 'GET') return self::$view->render('site.delete_division', ['divisions' => $divisions]);

        $post = $request->post;

        if ($post['id'] === 'fake') return self::$view->render('site.delete_division', ['divisions' => $divisions, 'message' => 'Выберите подразделение']);

        $division = Division::where('id', $post['id'])->first();

        if ($division->delete()) {
            $divisions = Division::all();
            return self::$view->render('site.delete_division', ['divisions' => $divisions, 'message' => 'Удалён успешно']);
        }
    }
}
