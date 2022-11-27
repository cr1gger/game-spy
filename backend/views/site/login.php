<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .login-center {
        display: flex;
        width: 100%;
        justify-content: center;
    }
    .site-login {
        max-width: 400px;
        background: #f5f5f5;
        padding: 30px;
        border-radius: 10px;
        -webkit-box-shadow: 0px 13px 10px -5px rgba(34, 60, 80, 0.6);
        -moz-box-shadow: 0px 13px 10px -5px rgba(34, 60, 80, 0.6);
        box-shadow: 0px 13px 10px -5px rgba(34, 60, 80, 0.6);
    }
</style>
<div class="login-center">
    <div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'login')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-12">
                <?= Html::submitButton('Войти', ['class' => 'btn w-100 btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
