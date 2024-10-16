<?php

/**
 * @var yii\web\View $this
 * @var $user
 * @var $teachers
 * @var $hss
 * @var $hss2
 * @var $reports
 * @var $btn
 */

use common\models\Category;
use common\models\Criteria;
use common\models\File;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Baishev KPI';
?>

<?php \yii\widgets\Pjax::begin()?>
<div class="d-flex">
    <div style="width: 30%; padding: 5px; height: 100%;">

        <!--имя и kpi-->
        <div>
            <?= GridView::widget([
                'dataProvider' => $user,
                'layout' => '{items}',
                'showHeader' => false,
                'tableOptions' => [
                    'class' => 'table table-bordered shadow',
                    'style' => 'border-radius: 10px; overflow: hidden;',
                ],
                'columns' => [
                    [
                        'value' => 'name',
                        'label' => 'Имя'
                    ],
                    [
                        'label' => 'KPI',
                        'value' => function () {
                            return '∞';
                        }
                    ]
                ]]);
            ?>
        </div>

        <br>

        <div class="shadow p-1" style="border-radius: 10px; border: 1px solid black;">
            <!--три кнопки-->
            <?= Html::a(Yii::t('app', 'Рейтинг преподавателей'),
                ['/admin/admin', 'btn' => 't', 'hs' => ''],
                ['style' => [
                    'text-align-last' => 'center',
                    'border' => '1px solid black',
                    'border-radius' => '5px',
                    'text-decoration' => 'inherit',
                    'display' => 'block',
                    'height' => '50px',
                    'width' => '100%',
                    'background-color' => '#adbbda',
                    'line-height' => '40px',
                    'color' => 'black',
                ]]);
            ?>
            <?= Html::a(Yii::t('app', 'Рейтинг высших школ'),
                ['/admin/admin', 'btn' => 'c', 'hs' => ''],
                [   'class' => 'mt-1 mb-1',
                    'style' => [
                        'text-align-last' => 'center',
                        'border' => '1px solid black',
                        'border-radius' => '5px',
                        'text-decoration' => 'inherit',
                        'display' => 'block',
                        'height' => '50px',
                        'width' => '100%',
                        'background-color' => '#adbbda',
                        'line-height' => '40px',
                        'color' => 'black',
                    ]]);
            ?>
            <?= Html::a(Yii::t('app', 'Отчет рейтингов'),
                ['/admin/admin', 'btn' => 'r', 'hs' => ''],
                ['style' => [
                    'text-align-last' => 'center',
                    'border' => '1px solid black',
                    'border-radius' => '5px',
                    'text-decoration' => 'inherit',
                    'display' => 'block',
                    'height' => '50px',
                    'width' => '100%',
                    'background-color' => '#adbbda',
                    'line-height' => '40px',
                    'color' => 'black',
                ]]);
            ?>
        </div>

    </div>

    <div style="width: 70%; padding-left: 20px;">

        <!--если нажал на кнопку рейтинг преподов-->
        <?php if($btn == 't'):?>
            <div class="dropdown shadow">
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
                            width: 100%;">
                    <?php if($hss2):?>
                        <?= Yii::t('app', $hss2->title)?>
                    <?php endif;?>
                </button>
                <ul class="dropdown-menu w-100">
                    <?php foreach ($hss->query->all() as $h):?>
                        <li class="dropdown-item" style="
                                background-color: #adbbda;
                                height: 50px;
                                border: 1px solid black;
                                border-radius: 5px;">
                            <?= Html::a(Yii::t('app', $h->title),
                                ['/admin/admin', 'btn' => $btn, 'hs' => $h->id],
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
                <?= GridView::widget([
                    'dataProvider' => $teachers,
                    'layout' => '{items}',
                    'tableOptions' => [
                        'class' => 'table table-bordered table-hover shadow',
                        'style' => 'border-radius: 10px; overflow: hidden;',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => Yii::t('app', 'Имя'),
                            'format' => 'html',
                            'value' => function ($model) {
                                return Html::a($model->user->name,
                                [
                                    '/expert/trating',
                                    'ctg' => '',
                                    'crit' => '',
                                    'uid' => $model->user_id
                                ], ['style' => 'color: black;']);
                            }
                        ],
                        [
                            'label' => Yii::t('app', 'Записи'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                $pendingCount = File::find()
                                    ->andWhere(['created_by' => $model->user_id])
                                    ->andWhere(['in', 'criteria_id', Criteria::find()
                                        ->andWhere(['in', 'category_id', Category::find()
                                            ->andWhere(['type' => 1])
                                            ->select('id')])
                                        ->select('id')])
                                    ->andWhere(['status' => 'ожидает'])
                                    ->count();
                                $text_many = 'color: #7091e6; font-weight: bold;';
                                $text_zero = 'color: black; display: none;';
                                $colorStyle = $pendingCount > 0 ? $text_many : $text_zero;
                                return "<span style='$colorStyle'>$pendingCount</span>";
                            }
                        ],
                        [
                            'label' => 'KPI',
                            'value' => 'score'
                        ]
                    ]]);
                ?>
            </div>

        <!--если нажал на кнопку рейтинг высших школ-->
        <?php elseif ($btn == 'c'):?>
            <div class="shadow p-1" style="border-radius: 10px; border: 1px solid black;">
                <?php foreach ($hss->query->all() as $h):?>
                    <li class="list-group-item-right m-1" style="
                    border: 1px solid black;
                    background-color: #adbbda;
                    border-radius: 5px;
                    padding: 10px;
                    line-height: 30px;
                    list-style-type: none;">
                        <?= Html::a(Yii::t('app', $h->title),
                            ['/expert/crating', 'ctg' => '', 'crit' => '', 'hs' => $h->id],
                            ['style' => [
                                'text-decoration' => 'inherit',
                                'color' => 'black',
                                'display' => 'block',
                                'min-height' => '30px',
                            ]])
                        ?>
                    </li>
                <?php endforeach;?>
            </div>


        <!--если нажал на кнопку отчет рейтингов-->
        <?php elseif ($btn == 'r'):?>

            <div class="shadow p-1" style="border-radius: 10px; border: 1px solid black;">
                <?php foreach ($reports->query->all() as $rprt):?>
                    <li class="list-group-item m-1" style="
                    border: 1px solid black;
                    background-color: #adbbda;
                    border-radius: 5px;
                    padding: 10px;
                    line-height: 30px;
                    list-style-type: none;">
                        <?= Html::a(Yii::t('app', $rprt->title),
                            ['/admin/report', 'rid' => $rprt->id, 'id' => ''],
                            [
                                'style' => [
                                    'text-decoration' => 'inherit',
                                    'color' => 'black',
                                    'display' => 'block',
                                    'min-height' => '30px',
                                ],
                                'data-pjax' => '0'
                            ])
                        ?>
                    </li>
                <?php endforeach;?>
            </div>



        <!--если нажал на кнопку внутри кнопки отчета рейтингов-->
        <?php elseif ($btn == 'rb1'):?>
            <div class="shadow p-1" style="border-radius: 10px; border: 1px solid black;">
                <?php foreach ($hss->query->all() as $h):?>
                    <li class="list-group-item m-1" style="
                    border: 1px solid black;
                    background-color: #adbbda;
                    border-radius: 5px;
                    padding: 10px;
                    line-height: 30px;
                    list-style-type: none;">
                        <?= Html::a($h->title,
                            ['/admin/report', 'rid' => 'rb1', 'id' => $h->id],
                            [
                                'style' => [
                                    'text-decoration' => 'inherit',
                                    'color' => 'black',
                                    'display' => 'block',
                                    'min-height' => '30px',
                                ],
                                'data-pjax' => '0'
                            ])
                        ?>
                    </li>
                <?php endforeach;?>
            </div>

        <?php endif;?>
    </div>
</div>
<?php \yii\widgets\Pjax::end()?>
