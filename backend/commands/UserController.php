<?php

namespace app\commands;

use app\models\User;
use app\services\UserService;
use yii\console\Controller;
use yii\helpers\Console;

class UserController extends Controller
{
    public function actionCreate()
    {
        $login = Console::input('Enter login: ');
        $password = Console::input('Enter password: ');

        $user = UserService::instance()->createUser($login, $password);

        echo "\n\nSuccess!\n";
        echo "Login: {$user->login}\nPassword: $password";
    }
}
