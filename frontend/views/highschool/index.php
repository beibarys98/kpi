<?php

use common\models\Highschool;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Высшие школы');
?>
<div class="highschool-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить'), ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'tableOptions' => [
            'class' => 'table table-bordered table-hover shadow',
            'style' => 'border-radius: 10px; overflow: hidden;',
        ],
        'columns' => [
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
            [
                'label' => 'KPI',
                'value' => function ($model) {
                    return Yii::$app->formatter
                        ->asDecimal($model->average + $model->score, 2);
                }
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'urlCreator' => function ($action, Highschool $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ]
        ]]);
    ?>

    <?php Pjax::end(); ?>

</div>
