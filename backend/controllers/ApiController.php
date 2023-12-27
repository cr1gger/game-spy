<?php

namespace app\controllers;

use app\models\Category;
use app\models\Words;
use yii\filters\Cors;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'GET'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;

        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Allow-Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'GET'],
                    'Access-Control-Request-Headers' => ['*'],
                ],

            ],
        ]);
    }
    public function actionIndex()
    {
        return [
            'version' => 1.0
        ];
    }

    public function actionWords()
    {
        return Words::find()
            ->select(['name', 'category_id'])
            ->all();
    }

    public function actionCategories()
    {
        $categoryIds = Words::find()
            ->select(['category_id'])
            ->distinct()
            ->column();

        return Category::find()
            ->select(['id', 'name'])
            ->where(['id' => $categoryIds])
            ->all();
    }
}
