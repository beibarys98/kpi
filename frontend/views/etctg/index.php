<?php

use common\models\EtCtg;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Ответственность');
?>
<div class="et-ctg-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить'),
            ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'tableOptions' => [
            'class' => 'table table-bordered table-hover shadow',
            'style' => 'border-radius: 10px; overflow: hidden;',
        ],
        'columns' => [
            [
                'label' => 'Эксперт',
                'attribute' => 'expert_id',
                'value' => 'expert.user.name'
            ],
            [
                'label' => 'Категория',
                'attribute' => 'category_id',
                'value' => 'category.category'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'urlCreator' => function ($action, EtCtg $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ]
        ]]);
    ?>


</div>
