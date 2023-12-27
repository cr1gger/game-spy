<?php

namespace app\controllers;

use app\models\Category;
use app\models\Words;
use Yii;
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
                'Origin' => [Yii::$app->request->getOrigin()],
                'Access-Control-Allow-Credentials' => true,
                // Allow  methods
                'Access-Control-Request-Method' => ['POST', 'PUT', 'OPTIONS', 'GET', 'DELETE'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Headers' => ['Content-Type'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
//                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching

                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['*']
            ],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;

//        return array_merge(parent::behaviors(), [
//            'corsFilter' => [
//                'class' => Cors::class,
//                'cors' => [
//                    'Origin' => ['*'],
//                    'Access-Control-Allow-Origin' => ['*'],
//                    'Access-Control-Request-Method' => ['POST', 'GET'],
//                    'Access-Control-Request-Headers' => ['*'],
//                ],
//
//            ],
//        ]);
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
