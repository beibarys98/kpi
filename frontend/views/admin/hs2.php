<?php
/**
 * @var $hs
 */

use common\models\Cafedra;
use common\models\Category;
use common\models\Criteria;
use common\models\File;
use common\models\Manager;

?>

<?php foreach ($hs->query->all() as $h):?>
    <table class="table table-bordered" style="page-break-after: auto;">
        <tbody>
        <tr>
            <td>п/п</td>
            <td>Показатель деятельности высшей школы</td>
            <td>Суммарный балл по каждому показателю</td>
        </tr>
        <tr>
            <td></td>
            <td>
                <strong><u><?= $h->title?></u></strong>
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <strong>Средний балл KPIппс</strong>
            </td>
            <td><?= Yii::$app->formatter->asDecimal($h->average, 2);?></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <strong>Активная деятельность высшей школы</strong>
            </td>
            <td></td>
        </tr>
        <?php $category = new \yii\data\ActiveDataProvider([
            'query' => Category::find()
                ->andWhere(['type' => '2'])
                ->andWhere(['!=', 'id', '11'])
        ]);?>
        <?php $sum2 = 0;?>
        <?php foreach ($category->query->all() as $ctg):?>
            <?php $criteria = new \yii\data\ActiveDataProvider([
                'query' => Criteria::find()
                    ->andWhere(['category_id' => $ctg->id])
                    ->andWhere(['in', 'id', File::find()
                        ->andWhere(['created_by' => Manager::find()
                            ->andWhere(['in', 'cafedra_id', Cafedra::find()
                                ->andWhere(['hs_id' => $h->id])
                                ->select('id')])
                            ->select('user_id')])
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
                <?php $sumar = $sum2;?>
                <strong><?= Yii::$app->formatter->asDecimal($h->average + $sumar, 2);?></strong>

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
                ->andWhere(['category_id' => '11'])
                ->andWhere(['in', 'id', File::find()
                    ->andWhere(['created_by' => Manager::find()
                        ->andWhere(['in', 'cafedra_id', Cafedra::find()
                            ->andWhere(['hs_id' => $h->id])
                            ->select('id')])
                        ->select('user_id')])
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
                <strong><?= Yii::$app->formatter->asDecimal($h->average + $h->score, 2);?></strong>
            </td>
        </tr>
        </tbody>
    </table>
<?php endforeach;?>