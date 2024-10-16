<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EtCtg $model */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $dataProvider2 */

$this->title = Yii::t('app', 'Добавить ответственность');
?>
<div class="et-ctg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'dataProvider2' => $dataProvider2,
    ]) ?>

</div>
