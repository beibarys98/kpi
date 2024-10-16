<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Teacher $model */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider2 */

$this->title = Yii::t('app', 'Изменить ППС');
?>
<div class="teacher-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'dataProvider2' => $dataProvider2,
    ]) ?>

</div>
