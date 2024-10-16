<?php
/**
 * @var $hs
 */
?>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Образовательные программы</th>
        <th scope="col">Суммарный балл ВШ</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1;?>
    <?php foreach ($hs->query->all() as $h):?>
        <tr>
            <th scope="row"><?= $i?></th>
            <td><?= $h->title?></td>
            <td><?= Yii::$app->formatter->asDecimal($h->score + $h->average, 2);?></td>
        </tr>
        <?php $i++;?>
    <?php endforeach;?>
    </tbody>
</table>