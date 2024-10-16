<?php

use common\models\Criteria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\CriteriaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Критерии');
?>
<div class="criteria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить'), ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'label' => 'Категория',
                'attribute' => 'category_id',
                'value' => 'category.category'
            ],
            [
                'label' => Yii::t('app', 'Номер'),
                'attribute' => 'number',
                'value' => 'number'
            ],
            [
                'label' => 'Критерий',
                'attribute' => 'criteria',
                'value' => 'criteria'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'urlCreator' => function ($action, Criteria $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ]
        ]]);
    ?>

    <?php Pjax::end(); ?>

</div>
