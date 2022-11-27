<?php

namespace app\controllers\base;

use yii\filters\AccessControl;
use yii\web\Controller;

abstract class BaseAdminController extends Controller
{
    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }
}
