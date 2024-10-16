<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Criteria $model */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<div class="criteria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->textInput(['placeholder' => Yii::t('app', 'ID категорий')])->label(false) ?>
    <br>
    <?= $form->field($model, 'number')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Номер')])->label(false) ?>
    <br>
    <?= $form->field($model, 'criteria')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Название')])->label(false) ?>
    <br>
    <?= $form->field($model, 'unit')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Единица измерения')])->label(false) ?>
    <br>
    <?= $form->field($model, 'points')->textInput(['placeholder' => Yii::t('app', 'Балл')])->label(false) ?>
    <br>
    <?= $form->field($model, 'condition')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Условие')])->label(false) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <br>

    <div>
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
