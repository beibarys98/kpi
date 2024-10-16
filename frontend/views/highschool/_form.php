<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Highschool $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="highschool-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'year')->textInput(['placeholder' => Yii::t('app', 'Год')])->label(false)?>
    <br>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Название')])->label(false) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>