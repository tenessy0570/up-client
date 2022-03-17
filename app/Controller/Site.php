<?php

namespace Controller;

use DateTime;
use Src\View;
use Src\Auth\Auth;
use Src\Request;
use Model\Post;
use Model\User;
use Model\State;
use Model\Division;
use Model\Company;
use Illuminate\Database\QueryException;

class Site
{
    public function index(Request $request): string
    {
        $posts = Post::where('id', $request->id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === "POST") {
            $error = '';
            $post = $request->post;
            $states = State::all();

            if ($post['password'] !== $post['password2']) $error = $error . 'Пароли не совпадают <br>';
            if ($post['state'] === 'fake') $error = $error . 'Выберите штат <br>';
            if ($post['gender'] === 'fake') $error = $error . 'Выберите пол <br>';

            if (!empty($error)) return new View('site.signup', ['error' => $error, 'states' => $states]);

            try {
                if (User::create($request->all())) {
                    app()->route->redirect('/hello');
                }
            } catch (QueryException $e) {
                return new View('site.signup', ['error' => 'Логин занят.', 'states' => $states]);
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

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function getAverageAge(): string
    {
        $users = User::all();
        $agesArray = [];
        $averageAge = 'Средний возраст, лет: ';
        foreach ($users as $user) {
            if ($user->role === 'admin') continue;
            $age = DateTime::createFromFormat('d/m/Y', date('d/m/Y', strtotime($user->birth_date)))
                ->diff(new DateTime('now'))
                ->y;
            array_push($agesArray, $age);
        }
        $averageAge = $averageAge . (string)ceil(array_sum($agesArray) / count($agesArray));
        return (new View)->render('site.hello', ['age' => $averageAge]);
    }

    public function getDivisionStaff(Request $request): string
    {
        $divisions = Division::all();

        if ($request->method === 'GET') {
            return new View('site.division_staff', ['divisions' => $divisions]);
        }

        // Получаем все штаты выбранного подразделения
        $divisionId = $request->post['division'];
        if ($divisionId === 'fake') return new View('site.division_staff', ['divisions' => $divisions]);

        $states = State::where('division', $divisionId)->get();

        // Получаем список всех сотрудников с каждого штата, добавляя его в $staff
        $staff = [];
        foreach ($states as $state) {
            $users = User::where('state', $state->id)->get();
            foreach ($users as $user) array_push($staff, $user);
        }

        // Меняем id Штата у каждого сотрудника в массиве на название этого штата
        for ($i = 0; $i < count($staff); $i += 1) {
            $workerState = State::where('id', $staff[$i]->state)->first();
            $staff[$i]->state_name = $workerState->name;
        }

        return (new View)->render('site.division_staff', ['divisions' => $divisions, 'staff' => $staff]);
    }

    public function getStateStaff(Request $request): string
    {
        $states = State::all();

        if ($request->method === 'GET') {
            return new View('site.state_staff', ['states' => $states]);
        }

        $stateId = $request->post['state'];
        if ($stateId === 'fake') return new View('site.state_staff', ['states' => $states]);

        $state = State::where('id', $stateId)->first();
        $staff = User::where('state', $state->id)->get();

        return (new View)->render('site.state_staff', ['states' => $states, 'staff' => $staff]);
    }

    public function createNewUser(Request $request): string
    {
        $states = State::all();
        if ($request->method === "GET") return (new View)->render('site.create_new_user', ['states' => $states]);
        $error = '';
        $post = $request->post;
        $states = State::all();

        if ($post['state'] === 'fake') $error = $error . 'Выберите штат <br>';
        if ($post['gender'] === 'fake') $error = $error . 'Выберите пол <br>';

        if (!empty($error)) return new View('site.create_new_user', ['error' => $error, 'states' => $states]);

        try {
            if (User::create($request->all())) {
                app()->route->redirect('/hello');
            }
        } catch (QueryException $e) {
            return new View('site.create_new_user', ['error' => 'Логин занят.', 'states' => $states]);
        }
    }

    public function createNewState(Request $request): string {
        $divisions = Division::all();
        if ($request->method === "GET") return (new View)->render('site.create_new_state', ['divisions' => $divisions]);
        
        $post = $request->post;
        $error = '';
        
        $divisionId = $post['division'];
        $allDivisionStates = State::where('division', $divisionId)->get();

        if ($post['division'] === 'fake') $error = $error . 'Выберите подразделение';

        if (!empty($error)) return new View('site.create_new_state', ['error' => $error, 'divisions' => $divisions]);

        foreach ($allDivisionStates as $state) {
            if ($state->name === $post['name']) {
                $error = $error . "В подразделении уже есть штат с таким названием";
                break;
            }
        }
        
        if (!empty($error)) return new View('site.create_new_state', ['error' => $error, 'divisions' => $divisions]);

        if (State::create($request->all())) {
            return (new View)->render('site.create_new_state', ['error' => 'Штат успешно создан']);
        }
        
        return (new View)->render('site.create_new_state', ['error' => 'Произошла ошибка']);
    }

    public function createNewDivision(Request $request)
    {
        $companies = Company::all();
        $view = new View();
        if ($request->method === 'GET') return $view->render('site.create_new_division', ['companies' => $companies]);

        $error = '';
        $post = $request->post;

        if ($post['company'] === 'fake') $error = $error . 'Выберите компанию <br>';
        
        if (!empty($error)) return $view->render('site.create_new_division', ['companies' => $companies, 'error' => $error]);

        $divisionsWithSameName = Division::where(['name' => $post['name'], 'company' => $post['company']])->get();
        foreach ($divisionsWithSameName as $division) {
            if ($division->type === $post['type']) {
                $error = $error . 'Подразделение такого типа уже существует в компании';
                return $view->render('site.create_new_division', ['companies' => $companies, 'error' => $error]);
            }
        }
        
        if (Division::create($request->all())) {
            return $view->render('site.create_new_division', ['companies' => $companies, 'error' => 'Успешно создано']);
        } else {
            // handle error
        }
    }

    public function deleteUser(Request $request): string
    {
        $users = User::all();

        // Убираем свой аккаунт из списка пользователей 
        for ($i = 0; $i < count($users); $i += 1) {
            if ($users[$i]->id == $_SESSION['id']) {
                unset($users[$i]);
                break;
            }
        }

        $view = new View();
        if ($request->method === 'GET') return $view->render('site.delete_user', ['users' => $users]);

        $post = $request->post;

        if($post['id'] === 'fake') return $view->render('site.delete_user', ['users' => $users, 'message' => 'Выберите пользователя']);

        $user = User::where('id', $post['id'])->first();

        if ($user->delete()) {
            $users = User::all();
            for ($i = 0; $i < count($users); $i += 1) {
                if ($users[$i]->id == $_SESSION['id']) {
                    unset($users[$i]);
                    break;
                }
            }
            return $view->render('site.delete_user', ['users' => $users, 'message' => 'Удалён успешно']);
        }
    }

    public function deleteState(Request $request): string
    {
        $states = State::all();
        $view = new View();
        if ($request->method === 'GET') return $view->render('site.delete_state', ['states' => $states]);

        $post = $request->post;

        if($post['id'] === 'fake') return $view->render('site.delete_state', ['states' => $states, 'message' => 'Выберите штат']);

        $state = State::where('id', $post['id'])->first();

        if ($state->delete()) {
            $states = State::all();
            return $view->render('site.delete_state', ['states' => $states, 'message' => 'Удалён успешно']);
        }
    }
}
