<?php

namespace app\services;

use Yii;

class AuthService implements \yii\base\StaticInstanceInterface
{
    use \yii\base\StaticInstanceTrait;

    public function canAccess(): bool
    {
        return Yii::$app->user->isGuest;
    }

    public function auth($login, $password)
    {

    }
}
