<?php

namespace app\services;


use app\models\User;
use Yii;
use yii\base\StaticInstanceTrait;

class UserService
{
    use StaticInstanceTrait;

    public function createUser($login, $password)
    {
        $user = User::findOne(['login' => $login]);

        if ($user) {
            throw new \Exception('User already exists!');
        }

        $user = new User();
        $user->login = $login;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        if(!$user->save()) {
            var_dump($user->errors);
            throw new \Exception('User not saved...');
        }


        return $user;
    }
}
