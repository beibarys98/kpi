<?php

/**
 * @var $declinedFiles
 * @var $acceptedFiles
 * @var $pendingFiles
 */

use common\models\Cafedra;
use common\models\Criteria;
use common\models\File;
use common\models\Highschool;
use common\models\Link;
use common\models\Manager;
use common\models\Teacher;
use common\models\User;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Baishev KPI';
?>

<div class="row">
    <div class="col-4">
        <?= GridView::widget([
            'dataProvider' => $declinedFiles,
            'tableOptions' => ['class' => 'table table-bordered table-striped shadow',
                'style' => 'border-radius: 10px; overflow: hidden;'],
            'showHeader' => false,
            'columns' => [
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->file.'.pdf',
                        ['/site/index', 'ctg' => Criteria::find()
                            ->andWhere(['id' => $model->criteria_id])
                            ->one()->category_id, 'crit' => $model->criteria_id],
                        [
                            'target' => '_blank',
                            'style' => 'color: black;'
                        ]);
                    },
                    'attribute' => 'file'
                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return "<span style='color: red; font-weight: bold;'>".$model->status."</span>";
                    },
                    'attribute' => 'status'
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{delete}',
                    'urlCreator' => function ($action, File $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ]
            ]
        ])?>
    </div>
    <div class="col-4">
        <?= GridView::widget([
            'dataProvider' => $pendingFiles,
            'tableOptions' => ['class' => 'table table-bordered table-striped shadow',
                'style' => 'border-radius: 10px; overflow: hidden;'],
            'showHeader' => false,
            'columns' => [
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->file.'.pdf',
                            ['/site/index', 'ctg' => Criteria::find()
                                ->andWhere(['id' => $model->criteria_id])
                                ->one()->category_id, 'crit' => $model->criteria_id],
                            [
                                'target' => '_blank',
                                'style' => 'color: black;'
                            ]);
                    },
                    'attribute' => 'file'
                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return "<span style='color: blue; font-weight: bold;'>".$model->status."</span>";
                    },
                    'attribute' => 'status'
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{delete}',
                    'urlCreator' => function ($action, File $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ]
            ]
        ])?>
    </div>
    <div class="col-4">
        <?= GridView::widget([
            'dataProvider' => $acceptedFiles,
            'tableOptions' => ['class' => 'table table-bordered table-striped shadow',
                'style' => 'border-radius: 10px; overflow: hidden;'],
            'showHeader' => false,
            'columns' => [
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::a($model->file.'.pdf',
                            ['/site/index', 'ctg' => Criteria::find()
                                ->andWhere(['id' => $model->criteria_id])
                                ->one()->category_id, 'crit' => $model->criteria_id],
                            [
                                'target' => '_blank',
                                'style' => 'color: black;'
                            ]);
                    },
                    'attribute' => 'file'
                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return "<span style='color: green; font-weight: bold;'>".$model->status."</span>";
                    },
                    'attribute' => 'status'
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{delete}',
                    'urlCreator' => function ($action, File $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ]
            ]
        ])?>
    </div>
</div>