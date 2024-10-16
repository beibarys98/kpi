<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Cafedra $model */
/** @var yii\widgets\ActiveForm $form */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>

<div class="cafedra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hs_id')->textInput(['placeholder' => Yii::t('app', 'ID высшей школы')])->label(false) ?>
    <br>
    <?= $form->field($model, 'cafedra')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Высшая школа')])->label(false) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <br>

    <?php if ($dataProvider->totalCount != 0):?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                'label' => Yii::t('app', 'Год'),
                'attribute' => 'year',
                'value' => 'year'
            ],
            [
                'label' => Yii::t('app', 'Высшая школа'),
                'attribute' => 'title',
                'value' => 'title'
            ],
        ],
    ]); ?>
    <?php endif;?>

</div>
