<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Пользователи');
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить'),
            ['create'], ['class' => 'btn btn-success']) ?>
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
                'label' => 'ID',
                'attribute' => 'id',
                'value' => 'id'
            ],
            [
                'label' => Yii::t('app', 'Имя'),
                'attribute' => 'name',
                'value' => 'name'
            ],
            [
                'label' => 'Логин',
                'attribute' => 'username',
                'value' => 'username'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
