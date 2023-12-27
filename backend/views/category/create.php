<?php

use app\models\MultiCategoryForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MultiCategoryForm $model */

$this->title = 'Создать категории';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form-center">
        <div class="category-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'category')->textarea(['rows' => 6, 'cols' => '50']) ?>

            <div class="form-group">
                <br>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


</div>
