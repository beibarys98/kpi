<?php

use common\models\File;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\FileSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Записи');
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-bordered table-hover shadow',
            'style' => 'border-radius: 10px; overflow: hidden;',
        ],
        'columns' => [
            'id',
            [
                'label' => 'Критерий',
                'attribute' => 'criteria_id',
                'value' => 'criteria.criteria'
            ],
            [
                'label' => Yii::t('app', 'Заголовок'),
                'attribute' => 'file',
                'value' => 'file'
            ],
            [
                'label' => Yii::t('app', 'Описание'),
                'attribute' => 'desc',
                'value' => 'desc'
            ],
            [
                'label' => 'Статус',
                'attribute' => 'status',
                'value' => 'status'
            ],
            [
                'label' => Yii::t('app', 'Загружено'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
                'attribute' => 'created_at'
            ],
            [
                'label' => Yii::t('app', 'Автор'),
                'attribute' => 'created_by',
                'value' => 'user.name'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'urlCreator' => function ($action, File $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ]
        ]]);
    ?>

    <?php Pjax::end(); ?>

</div>
