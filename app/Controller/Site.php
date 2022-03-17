<?php

namespace Controller;

use DateTime;
use DateTimeZone;
use Src\View;
use Src\Auth\Auth;
use Src\Request;
use Model\Post;
use Model\User;
use Model\State;
use Model\Division;
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
            $age = DateTime::createFromFormat('d/m/Y', date('d/m/Y', strtotime($user->birth_date)))
                ->diff(new DateTime('now'))
                ->y;
            array_push($agesArray, $age);
        }
        $averageAge = $averageAge . array_sum($agesArray) / count($agesArray);
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
}
