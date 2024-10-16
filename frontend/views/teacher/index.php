<?php

use common\models\Teacher;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\TeacherSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/**
 * @var $selectedItem
 */

$this->title = Yii::t('app', 'ППС');
?>
<div class="teacher-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex">
        <p>
            <?= Html::a(Yii::t('app', 'Добавить'),
                ['create'],
                ['class' => 'btn btn-success']) ?>
        </p>


    </div>

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
                'label' => Yii::t('app', 'Образовательная программа'),
                'attribute' => 'cafedra_id',
                'value' => 'cafedra.cafedra'
            ],
            [
                'label' => Yii::t('app', 'Имя'),
                'attribute' => 'user_id',
                'value' => 'user.name'
            ],
            [
                'label' => Yii::t('app', 'Степень'),
                'attribute' => 'degree',
                'value' => 'degree'
            ],
            [
                'label' => Yii::t('app', 'Должность'),
                'attribute' => 'position',
                'value' => 'position'
            ],
            [
                'label' => 'KPI',
                'attribute' => 'score',
                'value' => 'score'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'urlCreator' => function ($action, Teacher $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
