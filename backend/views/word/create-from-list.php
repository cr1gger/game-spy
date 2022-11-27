<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Words $model */
/** @var app\models\Category $categories */

$this->title = 'Создать слово';
$this->params['breadcrumbs'][] = ['label' => 'Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="words-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
