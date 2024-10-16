<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Cafedra $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Изменить ОП');
?>
<div class="cafedra-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider
    ]) ?>

</div>
