<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Highschool $model */

$this->title = Yii::t('app', 'Добавить высшую школу');
?>
<div class="highschool-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>