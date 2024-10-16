<?php

/** @var yii\web\View $this */
/**
 * @var $hss
 * @var $category
 * @var $category2
 * @var $criteria
 * @var $criteria2
 * @var $files
 */

use common\models\Cafedra;
use common\models\Criteria;
use common\models\File;
use common\models\Link;
use common\models\Manager;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Baishev KPI';
?>
<?php \yii\widgets\Pjax::begin(['timeout' => 10000])?>
<div class="d-flex">
    <div style="width: 30%; padding: 5px; height: 100%;">

        <!--имя и kpi-->
        <div>
            <?= GridView::widget([
                'dataProvider' => $hss,
                'layout' => '{items}',
                'showHeader' => false,
                'tableOptions' => [
                    'class' => 'table table-bordered shadow',
                    'style' => 'border-radius: 10px; overflow: hidden;',
                ],
                'columns' => [
                    [
                        'value' => 'title',
                        'label' => Yii::t('app', 'ВШ')
                    ],
                    [
                        'label' => 'KPI',
                        'value' => function ($model) {
                            return Yii::$app->formatter
                                ->asDecimal($model->average + $model->score, 2);
                        }
                    ]
                ],
            ]); ?>
        </div>

        <br>

        <!--категории и критерии-->
        <div class="shadow p-1" style="border-radius: 10px; border:1px solid black;">
            <div class="dropdown">
                <label><?= Yii::t('app', 'Категории')?></label>
                <button type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" class="btn" style="
                            height: 50px;
                            overflow: hidden;
                            background-color: #adbbda;
                            border: 1px solid black;
                            border-radius: 5px;
                            color: black;
                            text-align-last: start;
                            padding-left: 10px;
                            width: 100%;
                            white-space: nowrap;
                            text-overflow: ellipsis;">
                    <?php if($category2):?>
                        <?= Yii::$app->language == 'kz-KZ' ? $category2->category_kz : $category2->category?>
                    <?php endif;?>
                </button>
                <ul class="dropdown-menu w-100">
                    <?php foreach ($category->query->all() as $ctg):?>
                        <?php
                        $isPending = File::find()
                            ->andWhere(['criteria_id' => Criteria::find()
                                ->andWhere(['category_id' => $ctg->id])
                                ->select('id')])
                            ->andWhere(['status' => 'ожидает'])
                            ->andWhere(['created_by' => Manager::find()
                                ->andWhere(['in', 'cafedra_id', Cafedra::find()
                                    ->andWhere(['hs_id' => $hss->query->one()->id])
                                    ->select('id')])
                                ->select('user_id')])
                            ->one();
                        $backgroundColor = $isPending ? '#7091e6' : '#adbbda';
                        ?>
                        <li class="dropdown-item" style="
                            background-color: <?= $backgroundColor?>;
                            height: 50px;
                            border: 1px solid black;
                            border-radius: 5px;
                            padding-left: 10px;">
                        <?= Html::a(Yii::$app->language == 'kz-KZ' ? $ctg->category_kz : $ctg->category,
                            [
                                '/expert/crating',
                                'ctg' => $ctg->id,
                                'crit' => '',
                                'hs' => $hss->query->one()->id
                            ],
                            ['style' => [
                                'text-decoration' => 'inherit',
                                'color' => 'black',
                                'display' => 'block',
                                'line-height' => '40px'
                            ]])
                        ?>
                        </li>
                    <?php endforeach;?>

                </ul>
            </div>

            <br>

            <div>
                <label><?= Yii::t('app', 'Критерии')?></label>
                <ul class="list-group" style="
                    max-height: 370px;
                    overflow: auto;
                    width: 100%;">
                    <?php foreach ($criteria->query->all() as $crit):?>
                        <?php
                        $isPending = File::find()
                            ->andWhere(['criteria_id' => $crit->id])
                            ->andWhere(['status' => 'ожидает'])
                            ->andWhere(['created_by' => Manager::find()
                                ->andWhere(['in', 'cafedra_id', Cafedra::find()
                                    ->andWhere(['hs_id' => $hss->query->one()->id])
                                    ->select('id')])
                                ->select('user_id')])
                            ->one();
                        $backgroundColor = $isPending ? '#7091e6' : ($crit == $criteria2 ? '#adbbda' : '');
                        ?>
                        <li class="list-group-item" style="
                                background-color: <?= $backgroundColor ?>;
                                border: 1px solid black;
                                border-radius: 5px;">
                            <?= Html::a($crit->number.' '.(Yii::$app->language == 'kz-KZ' ? $crit->criteria_kz : $crit->criteria),
                                [
                                    '/expert/crating',
                                    'ctg' => $category2->id,
                                    'crit' => $crit->id,
                                    'hs' => $hss->query->one()->id
                                ],
                                ['style' => [
                                    'text-decoration' => 'inherit',
                                    'color' => 'black',
                                    'display' => 'block',
                                    'min-height' => '30px',
                                ]])
                            ?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <div style="width: 70%; padding-left: 20px;">

        <!--сохраненные файлы-->
        <div>
            <?php if($criteria2):?>
                <div class="shadow p-1" style="border-radius: 10px; border:1px solid black;">
                    <li class="list-group-item mb-1" style="
                    border: 1px solid black;
                    background-color: #adbbda;
                    border-radius: 5px;
                    padding: 10px;
                    line-height: 30px;
                    list-style-type: none;">
                        <?= $criteria2->number.' '.(Yii::$app->language == 'kz-KZ' ? $crit->criteria_kz : $crit->criteria)?>
                    </li>
                    <li class="list-group-item" style="
                    border: 1px solid black;
                    background-color: #adbbda;
                    border-radius: 5px;
                    padding: 10px;
                    line-height: 30px;
                    list-style-type: none;">
                        <?=Yii::t('app', 'Необходимо').': '.(Yii::$app->language == 'kz-KZ' ? $criteria2->condition_kz : $criteria2->condition)?>
                    </li>
                </div>

                <br>
                <div>
                    <?= GridView::widget([
                        'dataProvider' => $files,
                        'layout' => '{items}',
                        'tableOptions' => [
                            'class' => 'table table-bordered table-hover shadow',
                            'style' => 'border-radius: 10px; overflow: hidden;',
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => Yii::t('app', 'Заголовок'),
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->file.'.pdf',
                                    ['/site/download', 'id' => $model->id],
                                    [
                                        'data-pjax' => '0',
                                        'target' => '_blank',
                                        'style' => 'color: black;'
                                    ]);
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Ссылка'),
                                'visible' => strpos($criteria2->condition,'ссылка на')
                                                ? true : false,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a(Yii::t('app', 'ссылка'),
                                    Link::findOne(['file_id' => $model->id])->link,
                                    [
                                        'target' => '_blank'
                                    ]);
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Автор'),
                                'format' => 'html',
                                'value' => function ($model) {
                                    return User::find()->andWhere(['id' => $model->created_by])->one()->name;
                                }
                            ],
                            [
                                'label' => Yii::t('app', 'Загружено'),
                                'format' => 'datetime',
                                'value' => 'created_at'
                            ],
                            [
                                'value' => 'status',
                                'label' => 'Статус'
                            ],
                            [
                                'label' => Yii::t('app', 'Оценить'),
                                'format' => 'html',
                                'value' => function ($model) {
                                    return Html::a(Yii::t('app', 'Принять'),
                                    [
                                        '/expert/plus',
                                        'id' => $model->id,
                                        'crit' => $model->criteria_id,
                                        'view' => Yii::$app->controller->action->id
                                    ],
                                    [
                                        'class' => $model->status == 'принято'
                                        ? 'btn btn-success disabled'
                                        : 'btn btn-outline-success'
                                    ]) . ' ' .
                                    Html::a(Yii::t('app', 'Отклонить'),
                                    [
                                        '/expert/minus',
                                        'id' => $model->id,
                                        'crit' => $model->criteria_id,
                                        'view' => Yii::$app->controller->action->id
                                    ],
                                    [
                                        'class' => $model->status == 'отклонено'
                                        ? 'btn btn-danger disabled'
                                        : 'btn btn-outline-danger'
                                    ]);
                                }
                            ]
                        ]]);
                    ?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
<?php \yii\widgets\Pjax::end()?>
