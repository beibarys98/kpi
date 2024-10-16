<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Criteria $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Добавить критерий');
?>
<div class="criteria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider
    ]) ?>

</div>
