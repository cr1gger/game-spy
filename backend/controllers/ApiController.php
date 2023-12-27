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
