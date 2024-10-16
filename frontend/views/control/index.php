<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\ActiveDataProvider $dataProvider2 */
/** @var yii\data\ActiveDataProvider $dataProvider3 */

$this->title = 'Controls';
?>
<div class="control-index mt-5">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'tableOptions' => [
            'class' => 'table table-bordered shadow',
            'style' => 'border-radius: 10px; overflow: hidden;',
        ],
        'columns' => [
            [
                'label' => Yii::t('app', 'Доступ ППС'),
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(Yii::t('app', 'вкл'), ['/control/on', 'tgl' => 't'], [
                            'class' => $model->teacher == 1
                                ? 'btn btn-success disabled'
                                : 'btn btn-outline-success'
                        ]) . ' ' .
                        Html::a(Yii::t('app', 'выкл'), ['/control/off', 'tgl' => 't'], [
                            'class' => $model->teacher == 0
                                ? 'btn btn-danger disabled'
                                : 'btn btn-outline-danger'
                        ]);
                }
            ],
            [
                'label' => Yii::t('app', 'Доступ руководителей'),
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(Yii::t('app', 'вкл'), ['/control/on', 'tgl' => 'm'], [
                            'class' => $model->manager == 1
                                ? 'btn btn-success disabled'
                                : 'btn btn-outline-success'
                        ]) . ' ' .
                        Html::a(Yii::t('app', 'выкл'), ['/control/off', 'tgl' => 'm'], [
                            'class' => $model->manager == 0
                                ? 'btn btn-danger disabled'
                                : 'btn btn-outline-danger'
                        ]);
                }
            ],
            [
                'label' => Yii::t('app', 'Доступ экспертов'),
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(Yii::t('app', 'вкл'), ['/control/on', 'tgl' => 'e'], [
                            'class' => $model->expert == 1
                                ? 'btn btn-success disabled'
                                : 'btn btn-outline-success'
                        ]) . ' ' .
                        Html::a(Yii::t('app', 'выкл'), ['/control/off', 'tgl' => 'e'], [
                            'class' => $model->expert == 0
                                ? 'btn btn-danger disabled'
                                : 'btn btn-outline-danger'
                        ]);
                }
            ]
        ]]);
    ?>
</div>