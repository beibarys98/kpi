<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Manager $model */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider2 */

$this->title = Yii::t('app', 'Добавить руководителя');
?>
<div class="manager-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'dataProvider2' => $dataProvider2,
    ]) ?>

</div>
