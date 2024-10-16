<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Expert $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<div class="expert-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')
        ->textInput(['placeholder' => Yii::t('app', 'ID пользователя')])
        ->label(false) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}',
        'tableOptions' => [
            'class' => 'table table-bordered table-hover shadow',
            'style' => 'border-radius: 10px; overflow: hidden;',
        ],
        'columns' => [
            [
                'label' => 'ID',
                'attribute' => 'id',
                'value' => 'id'
            ],
            [
                'label' => 'Имя',
                'attribute' => 'name',
                'value' => 'name'
            ],
            [
                'label' => 'Логин',
                'attribute' => 'username',
                'value' => 'username'
            ],
        ],
    ]); ?>

</div>
