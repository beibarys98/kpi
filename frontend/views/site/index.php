<?php

/**
 * @var yii\web\View $this
 * @var $user
 * @var $category
 * @var $category2
 * @var $criteria
 * @var $criteria2
 * @var $newFile
 * @var $files
 * @var $link
 */

use common\models\Cafedra;
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

<div class="d-flex">
    <div style="width: 30%; padding: 5px; height: 100%;">

        <!--показываю имя и kpi-->
        <!--если заходит менеджер, показываю высшую школу-->
        <!--если заходит учитель, показываю его/ее-->
        <div>
            <?= GridView::widget([
                'dataProvider' => $user,
                'showHeader' => false,
                'tableOptions' => ['class' => 'table table-bordered table-striped shadow',
                    'style' => 'border-radius: 10px; overflow: hidden;'],
                'layout' => '{items}',
                'columns' => [
                    [
                        'value' => function ($model) {
                            return Manager::find()->andWhere(['user_id' => $model->id])->one()
                                ? Highschool::find()
                                    ->andWhere(['in', 'id', Cafedra::find()
                                        ->andWhere(['in', 'id', Manager::find()
                                            ->andWhere(['user_id' => $model->id])
                                            ->select('cafedra_id')])
                                        ->select('hs_id')])
                                    ->one()->title
                                : User::find()->andWhere(['id' => $model->id])->one()->name;
                        }
                    ],
                    [
                        'value' => function ($model) {
                            return Manager::find()->andWhere(['user_id' => $model->id])->one()
                                ? Yii::$app->formatter
                                    ->asDecimal(Highschool::find()
                                            ->andWhere(['in', 'id', Cafedra::find()
                                                ->andWhere(['in', 'id', Manager::find()
                                                    ->andWhere(['user_id' => $model->id])
                                                    ->select('cafedra_id')])
                                                ->select('hs_id')])
                                            ->one()->score
                                        + Highschool::find()
                                            ->andWhere(['in', 'id', Cafedra::find()
                                                ->andWhere(['in', 'id', Manager::find()
                                                    ->andWhere(['user_id' => $model->id])
                                                    ->select('cafedra_id')])
                                                ->select('hs_id')])
                                            ->one()->average, 2)
                                : Teacher::find()->andWhere(['user_id' => $model->id])->one()->score;
                        }
                    ]
                ],
            ]); ?>
        </div>

        <br>

        <!--категории и критерии-->
        <div class="shadow p-1" style="border-radius: 10px; border: 1px solid black;">
            <div class="dropdown">
                <label><?= Yii::t('app', 'Категории')?></label>
                <button type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        class="btn" style="
                            height: 50px;
                            overflow: hidden;
                            background-color: #adbbda;
                            border: 1px solid black;
                            border-radius: 5px;
                            color: black;
                            text-align-last: start;
                            padding-left: 10px;
                            width: 100%;">
                    <?php if($category2):?>
                        <?= Yii::$app->language == 'kz-KZ' ? $category2->category_kz : $category2->category?>
                    <?php endif;?>
                </button>
                <ul class="dropdown-menu w-100">
                    <?php foreach ($category->query->all() as $ctg):?>
                        <li class="dropdown-item" style="
                            background-color: #adbbda;
                            height: 50px;
                            border: 1px solid black;
                            border-radius: 5px;
                            padding-left: 10px;" >
                        <?= Html::a(Yii::$app->language == 'kz-KZ' ? $ctg->category_kz : $ctg->category,
                            ['/site/index', 'ctg' => $ctg->id, 'crit' => ''],
                            ['style' => [
                                'text-decoration' => 'inherit',
                                'color' => 'black',
                                'display' => 'block',
                                'line-height' => '40px'
                            ]])?>
                        </li>
                    <?php endforeach;?>

                </ul>
            </div>

            <br>

            <div class="dropdown">
                <label><?= Yii::t('app', 'Критерии')?></label>
                <ul class="list-group" style="max-height: 400px;
                    overflow: auto;
                    width: 100%;">
                    <?php foreach ($criteria->query->all() as $crit):?>
                            <li class="list-group-item" style="
                                background-color: <?= $crit == $criteria2 ? '#adbbda' : ''?>;
                                border: 1px solid black;
                                border-radius: 5px;">
                            <?= Html::a($crit->number.' '.(Yii::$app->language == 'kz-KZ' ? $crit->criteria_kz : $crit->criteria),
                                ['/site/index', 'ctg' => $category2->id, 'crit' => $crit->id],
                                ['style' => [
                                    'text-decoration' => 'inherit',
                                    'color' => 'black',
                                    'display' => 'block',
                                    'min-height' => '30px'
                                ]])?>
                            </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <div style="width: 70%; padding-left: 20px;">

        <!--закачивание файлов-->
        <div>
            <?php if($criteria2):?>
                <div class="shadow p-1" style="border-radius: 10px; border: 1px solid black;">
                    <li class="list-group-item mb-1" style="
                        border: 1px solid black;
                        background-color: #adbbda;
                        border-radius: 5px;
                        padding: 10px;
                        line-height: 30px;
                        list-style-type: none;">
                        <?= $criteria2->number.' '.(Yii::$app->language == 'kz-KZ' ? $criteria2->criteria_kz : $criteria2->criteria)?>
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

                <div class="shadow p-1" style="border-radius: 10px; border: 1px solid black;">
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>

                    <?= $form->field($newFile, 'file')
                        ->textInput(['maxlength' => true])
                        ->label(Yii::t('app', 'Заголовок')) ?>

                    <?= $form->field($newFile, 'desc')
                        ->textarea(['rows' => '1'])
                        ->label(Yii::t('app', 'Описание')) ?>

                    <?= $form->field($newFile, 'newFile')
                        ->fileInput(['class' => 'form-control'])
                        ->label('Файл')?>

                    <?php if(strpos($criteria2->condition,'ссылка на') !== false):?>
                        <?= $form->field($link, 'link')
                            ->textInput()
                            ->label(Yii::t('app', 'Ссылка'))?>
                    <?php endif;?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Сохранить'),
                            ['class' => 'btn btn-success mt-3']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>


                <br>

                <!--сохраненные файлы-->
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
                                            'target' => '_blank',
                                            'style' => 'color: black;'
                                        ]);
                                    }
                                ],
                                [
                                    'label' => Yii::t('app', 'Ссылка'),
                                    'visible' => strpos($criteria2->condition,'ссылка на') ? true : false ,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return Html::a(Yii::t('app', 'ссылка'),
                                        Link::find()->andWhere(['file_id' => $model->id])->one()->link,
                                        [
                                            'target' => '_blank',
                                            'style' => 'color: black;'
                                        ]);
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
                                    'class' => ActionColumn::className(),
                                    'template' => '{delete}',
                                    'urlCreator' => function ($action, File $file, $key, $index, $column) {
                                        return Url::toRoute([$action, 'id' => $file->id]);
                                    }
                                ],
                            ],
                        ]); ?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
