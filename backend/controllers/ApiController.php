<?php

namespace app\controllers;

use app\models\Category;
use app\models\Words;
use yii\filters\Cors;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'GET'],
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
