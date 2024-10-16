<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Manager $model */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider2 */
?>

<div class="manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cafedra_id')->textInput(['placeholder' => Yii::t('app', 'ID образовательной программы')])->label(false) ?>
    <br>
    <?= $form->field($model, 'user_id')->textInput(['placeholder' => Yii::t('app', 'ID пользователя')])->label(false) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div class="d-flex">
    <div class="w-50 m-3">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
            'tableOptions' => [
                'class' => 'table table-bordered table-hover shadow',
                'style' => 'border-radius: 10px; overflow: hidden;',
            ],
            'columns' => [
                'id',
                [
                    'label' => Yii::t('app', 'Образовательная программа'),
                    'attribute' => 'cafedra',
                    'value' => 'cafedra'
                ]
            ],
        ]); ?>
    </div>

    <div class="w-50 m-3">
        <?= GridView::widget([
            'dataProvider' => $dataProvider2,
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
                    'label' => Yii::t('app', 'Имя'),
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
</div>