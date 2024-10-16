<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\models\Admin;
use common\models\Expert;
use common\models\Manager;
use common\models\Teacher;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/logo-1.png']);?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);

        $items = [];

        if(!Yii::$app->user->isGuest && (Teacher::find()
                ->andWhere(['user_id' => Yii::$app->user->id])->one())){
            $items[] = ['label' => 'Baishev KPI',
                'url' => ['/site/index', 'ctg' => '', 'crit' => '']];
            $items[] = ['label' => Yii::t('app', 'Записи'),
                'url' => ['/site/post']];
        }
        else if(!Yii::$app->user->isGuest && (Manager::find()
                ->andWhere(['user_id' => Yii::$app->user->id])->one())){
            $items[] = ['label' => 'Baishev KPI',
                'url' => ['/site/index', 'ctg' => '', 'crit' => '']];
            $items[] = ['label' => Yii::t('app', 'Записи'),
                'url' => ['/site/post']];
        }
        else if(!Yii::$app->user->isGuest && (Expert::find()
                ->andWhere(['user_id' => Yii::$app->user->id])->one())){
            $items[] = ['label' => 'Baishev KPI',
                'url' => ['/expert/expert', 'btn' => '', 'hs' => '']];
        }
        else if(!Yii::$app->user->isGuest && (Admin::find()
                ->andWhere(['user_id' => Yii::$app->user->id])->one())){
            $items[] = ['label' => 'Baishev KPI',
                'url' => ['/admin/admin', 'btn' => '', 'hs' => '']];
            $items[] = ['label' => Yii::t('app', 'Люди'), 'items' => [
                ['label' => Yii::t('app', 'Пользователи'), 'url' => ['/user/index']],
                ['label' => Yii::t('app', 'Админы'), 'url' => ['/admn/index']],
                ['label' => Yii::t('app', 'Руководители'), 'url' => ['/manager/index']],
                ['label' => 'ППС', 'url' => ['/teacher/index']]
            ]];
            $items[] = ['label' => Yii::t('app', 'Эксперты'), 'items' => [
                ['label' => Yii::t('app', 'Эксперты'), 'url' => ['/exprt/index']],
                ['label' => Yii::t('app', 'Ответственность'), 'url' => ['/etctg/index']],
            ]];
            $items[] = ['label' => Yii::t('app', 'Оценка'), 'items' => [
                ['label' => Yii::t('app', 'Категории'), 'url' => ['/category/index']],
                ['label' => Yii::t('app', 'Критерии'), 'url' => ['/criteria/index']],
                ['label' => Yii::t('app', 'Записи'), 'url' => ['/file/index']]
            ]];
            $items[] = ['label' => 'Университет', 'items' => [
                ['label' => Yii::t('app', 'Высшие школы'), 'url' => ['/highschool/index']],
                ['label' => Yii::t('app', 'Образовательные программы'), 'url' => ['/cafedra/index']],
            ]];

            $items[] = ['label' => Yii::t('app', 'Доступ'), 'url' => ['/control/index']];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $items
        ]);

        if (Yii::$app->user->isGuest) {
            echo Html::tag('div',
                Html::a(Yii::t('app', 'Язык').': '.Yii::$app->language,
                ['/site/language', 'view' => '/'.Yii::$app->controller->id.'/'.Yii::$app->controller->action->id],
                ['class' => ['btn btn-link login text-decoration-none']]),
                ['class' => ['d-flex']]);
            echo Html::tag('div',Html::a(Yii::t('app', 'Войти'),
                ['/site/login'],
                ['class' => ['btn btn-link login text-decoration-none']]),
                ['class' => ['d-flex']]);
        } else {
            echo Html::tag('div',Html::a(Yii::t('app', 'Сменить пароль'),
                ['/site/reset-password'],
                ['class' => ['btn btn-link login text-decoration-none']]),
                ['class' => ['d-flex']]);
            echo Html::tag('div',
                Html::a(Yii::t('app', 'Язык').': '.Yii::$app->language,
                ['/site/language', 'view' => '/'.Yii::$app->controller->id.'/'.Yii::$app->controller->action->id],
                ['class' => ['btn btn-link login text-decoration-none']]),
                ['class' => ['d-flex']]);
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(Yii::t('app', 'Выйти')
                    .' ('. Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout text-decoration-none']
                )
                . Html::endForm();
        }
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
