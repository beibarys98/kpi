<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Highschool $model */

$this->title = Yii::t('app', 'Изменить Высшую Школу');
?>
<div class="highschool-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
