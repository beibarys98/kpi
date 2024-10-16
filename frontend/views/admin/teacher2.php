<?php
/**
 * @var $teacher
 */

use common\models\Category;
use common\models\Criteria;
use common\models\File;

?>

    <?php foreach ($teacher->query->all() as $t):?>
            Ф.И.О. преподавателя <u><?= $t->user->name?></u><br>
            Высшей школы <u><?= $t->cafedra->highschool->title?></u><br>
            Должность <u><?= $t->position?></u>
        <br>
        <br>

            <table class="table table-bordered" style="page-break-after: always;">
                <tbody>
                <tr>
                    <td>п/п</td>
                    <td>Показатель деятельности преподавателя</td>
                    <td>Суммарный балл по каждому показателю</td>
                </tr>
                    <tr>
                        <td></td>
                        <td>
                            <strong>Достигнутый квалификационный уровень (ДКУ)</strong>
                            </td>
                        <td></td>
                    </tr>
                    <?php $criteria = new \yii\data\ActiveDataProvider([
                        'query' => Criteria::find()
                            ->andWhere(['category_id' => '1'])
                            ->andWhere(['in', 'id', File::find()
                                ->andWhere(['created_by' => $t->user_id])
                                ->andWhere(['status' => 'принято'])
                                ->select('criteria_id')])
                    ]);?>
                    <?php $sum2 = 0;?>
                    <?php foreach ($criteria->query->all() as $crit):?>
                    <?php $file = new \yii\data\ActiveDataProvider([
                            'query' => File::find()->andWhere(['criteria_id' => $crit->id])
                        ]);?>
                    <?php $sum = 0;?>
                    <?php foreach ($file->query->all() as $f):?>
                        <?php $sum += $crit->points;?>
                        <?php $sum2 += $crit->points;?>
                    <?php endforeach;?>
                    <tr>
                        <td><?= $crit->number?></td>

                        <td>
                            <?= $crit->criteria?>
                        </td>
                        <td><?= $sum;?></td>
                    </tr>
                    <?php endforeach;?>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <strong>Всего баллов по разделу 1</strong>
                        </td>
                        <td>
                            <strong><?= $sum2;?></strong>
                            <?php $dku = $sum2;?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <strong>Активная деятельность преподавателя (АДП)</strong>
                        </td>
                        <td></td>
                    </tr>
                    <?php $category = new \yii\data\ActiveDataProvider([
                            'query' => Category::find()->andWhere(['in', 'id', [2, 3, 4, 5]])
                    ]);?>
                    <?php $sum2 = 0;?>
                    <?php foreach ($category->query->all() as $ctg):?>
                    <?php $criteria = new \yii\data\ActiveDataProvider([
                        'query' => Criteria::find()
                            ->andWhere(['category_id' => $ctg->id])
                            ->andWhere(['in', 'id', File::find()
                                ->andWhere(['created_by' => $t->user_id])
                                ->andWhere(['status' => 'принято'])
                                ->select('criteria_id')])
                            ->orderBy(['id' => SORT_ASC])
                    ]);?>

                        <?php foreach ($criteria->query->all() as $crit):?>
                            <?php $file = new \yii\data\ActiveDataProvider([
                                'query' => File::find()->andWhere(['criteria_id' => $crit->id])
                            ]);?>
                            <?php $sum = 0;?>
                            <?php foreach ($file->query->all() as $f):?>
                                <?php $sum += $crit->points;?>
                                <?php $sum2 += $crit->points;?>
                            <?php endforeach;?>
                            <tr>
                                <td><?= $crit->number?></td>

                                <td>
                                    <em>
                                        <?= $ctg->category?>
                                    </em>

                                    <br>
                                    <?= $crit->criteria?>
                                </td>
                                <td><?= $sum;?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endforeach;?>
                    <tr>
                        <td></td>
                        <td>
                            <strong>Всего баллов по разделу 2</strong>
                        </td>
                        <td>
                            <strong><?= $sum2;?></strong>
                            </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <strong>Суммарный балл по всем разделам</strong>
                        </td>
                        <td>
                            <?php $sumar = $dku + 1.5 * $sum2;?>
                            <strong><?= $sumar;?></strong>

                        </td>
                    </tr>



                    <tr>
                        <td></td>
                        <td>
                            <strong>Снижающие показатели</strong>
                        </td>
                        <td></td>
                    </tr>
                    <?php $criteria = new \yii\data\ActiveDataProvider([
                        'query' => Criteria::find()
                            ->andWhere(['category_id' => '6'])
                            ->andWhere(['in', 'id', File::find()
                                ->andWhere(['created_by' => $t->user_id])
                                ->andWhere(['status' => 'принято'])
                                ->select('criteria_id')])
                            ->orderBy(['id' => SORT_ASC])
                    ]);?>
                    <?php $sum2 = 0;?>
                    <?php foreach ($criteria->query->all() as $crit):?>
                        <?php $file = new \yii\data\ActiveDataProvider([
                            'query' => File::find()->andWhere(['criteria_id' => $crit->id])
                        ]);?>
                        <?php $sum = 0;?>
                        <?php foreach ($file->query->all() as $f):?>
                            <?php $sum += $crit->points;?>
                            <?php $sum2 += $crit->points;?>
                        <?php endforeach;?>
                        <tr>
                            <td><?= $crit->number?></td>

                            <td>
                                <?= $crit->criteria?>
                            </td>
                            <td><?= $sum;?></td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td></td>
                        <td>
                            <strong>Всего баллов по разделу 3</strong>
                        </td>
                        <td>
                            <strong><?= $sum2;?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <strong>Итого KPIппс в баллах</strong>
                        </td>
                        <td>
                            <strong><?= $t->score;?></strong>
                        </td>
                    </tr>

                </tbody>
            </table>
    <?php endforeach;?>

