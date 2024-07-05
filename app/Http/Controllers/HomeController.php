<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()){
            return redirect()
                ->action([AuthController::class, 'postSignin']);
        }

        $users = User::all();

        return view('home', ['users' => $users]);
    }

    public function profile($id)
    {
        if (!Auth::check()){
            return redirect()
                ->action([AuthController::class, 'postSignin']);
        }

        $user = User::query()->find($id);

        return view('profile', ['user' => $user]);
    }

    public function edit($id)
    {
        if (!Auth::check()){
            return redirect()
                ->action([AuthController::class, 'postSignin']);
        }

        $user = User::query()->find($id);

        return view('edit', ['user' => $user]);
    }

    public function postEdit(EditUserRequest $request, $id)
    {
        if (!Auth::check()){
            return redirect()
                ->action([AuthController::class, 'postSignin']);
        }

        $userData = $request->post();

        $user = User::query()->find($id);

        $user['login'] = $userData['login'];
        $user['first_name'] = $userData['first_name'];
        $user['last_name'] = $userData['last_name'];
        $user['patronymic'] = $userData['patronymic'];
        $user->update();

        return redirect()
            ->action([HomeController::class, 'index']);
    }

    public function remove($id)
    {
        if (!Auth::check()){
            return redirect()
                ->action([AuthController::class, 'postSignin']);
        }

        $user = User::query()->find($id);
        $user->delete();

        return redirect()
            ->action([HomeController::class, 'index'])
            ->with('success', 'Пользователь успешно удален');
    }
}
