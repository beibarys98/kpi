<?php
/**
 * @var $teacher
 */
?>

<table class="table table-bordered">
    <tbody>
    <tr>
        <td>п/п</td>
        <td>Высшая школа</td>
        <td>ФИО Преподавателя</td>
        <td>Ученая степень, звание</td>
        <td>Должность</td>
        <td>KPI в баллах</td>
    </tr>
    <?php $i = 1;?>
    <?php foreach ($teacher->query->all() as $t):?>
        <tr>
            <td><?= $i?></td>
            <td><?= $t->cafedra->highschool->title?></td>
            <td><?= $t->user->name?></td>
            <td><?= $t->degree?></td>
            <td><?= $t->position?></td>
            <td><?= $t->score?></td>
        </tr>
        <?php $i++;?>
    <?php endforeach;?>
    </tbody>
</table>