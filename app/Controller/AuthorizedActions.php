<?php

namespace Controller;

use DateTime;
use Src\View;
use Src\Auth\Auth;
use Src\Request;
use Model\User;
use Model\State;
use Model\Division;


class AuthorizedActions
{
    public function hello(): string
    {
        $isAdmin = Auth::isAdmin();
        return new View('site.hello', ['message' => 'hello working', 'isAdmin' => $isAdmin]);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function getAverageAge(): string
    {
        $users = User::where('role', '!=', 'admin')->get();
        $agesArray = [];
        $averageAge = 'Средний возраст, лет: ';
        foreach ($users as $user) {
            $age = DateTime::createFromFormat('d/m/Y', date('d/m/Y', strtotime($user->birth_date)))
                ->diff(new DateTime('now'))
                ->y;
            array_push($agesArray, $age);
        }
        $averageAge = $averageAge . (string)ceil(array_sum($agesArray) / count($agesArray));
        return (new View)->render('site.hello', ['age' => $averageAge, 'isAdmin' => Auth::isAdmin()]);
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
