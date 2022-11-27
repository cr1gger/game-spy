<?php

namespace app\controllers;

use app\controllers\base\BaseAdminController;
use app\models\Category;
use app\models\User;
use app\models\Words;
use Yii;

class AdminController extends BaseAdminController
{
    public function actionIndex() {
        $words = Words::find()->count();
        $category = Category::find()->count();
        $users = User::find()->count();

        return $this->render('index', compact('words', 'category', 'users'));
    }
}
