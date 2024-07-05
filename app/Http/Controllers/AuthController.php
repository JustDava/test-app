<?php

namespace App\Http\Controllers;

use App\Http\Requests\SigninUserRequest;
use App\Http\Requests\SignupUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function postSignin(SigninUserRequest $request)
    {
        if (!Auth::attempt($request->only('login', 'password')))
        {
            return redirect()
                ->action([AuthController::class, 'postSignin'])
                ->with('danger', 'Неправильный логин или пароль');
        }
        else {
            return redirect()
                ->action([HomeController::class, 'index']);
        }
    }

    public function postSignup(SignupUserRequest $request)
    {
        $userData = $request->post();

        $user = new User();
        $user['login'] = $userData['login'];
        $user['password'] = password_hash($userData['password'], CRYPT_SHA256);
        $user['first_name'] = $userData['first_name'];
        $user['last_name'] = $userData['last_name'];
        $user['patronymic'] = $userData['patronymic'];
        $user->save();

        Auth::loginUsingId($user->id);

        return redirect()
            ->action([HomeController::class, 'index'])
            ->with('success', 'Вы успешно зарегистрировались');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()
            ->action([AuthController::class, 'postSignin']);
    }
}
