<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Words $model */
/** @var app\models\Category $categories */

$this->title = 'Обновить слово: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Слова', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="words-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories

    ]) ?>

</div>
