<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EtCtg $model */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $dataProvider2 */
?>

<div class="et-ctg-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'expert_id')->textInput(['placeholder' => Yii::t('app', 'ID эксперта')])->label(false) ?>
    <br>
    <?= $form->field($model, 'category_id')->textInput(['placeholder' => Yii::t('app', 'ID категорий')])->label(false) ?>
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
                    'label' => 'Эксперт',
                    'attribute' => 'user_id',
                    'value' => 'user.name'
                ]
            ],
        ]); ?>
    </div>

    <div class="w-50 m-3">
        <?= GridView::widget([
            'dataProvider' => $dataProvider2,
            'layout' => '{items}',
            'tableOptions' => [
                'class' => 'table table-bordered table-hover shadow',
                'style' => 'border-radius: 10px; overflow: hidden;',
            ],
            'columns' => [
                'id',
                [
                    'label' => 'Категория',
                    'attribute' => 'category',
                    'value' => 'category'
                ],
                [
                    'label' => Yii::t('app', 'Вид'),
                    'attribute' => 'type',
                    'value' => 'type'
                ],
            ],
        ]); ?>
    </div>
</div>