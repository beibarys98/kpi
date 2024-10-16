<?php

namespace frontend\controllers;

use common\models\Cafedra;
use common\models\Highschool;
use common\models\Report;
use common\models\Teacher;
use common\models\User;
use kartik\mpdf\Pdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    //админская страница
    public function actionAdmin($btn = '', $hs = '')
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        //отправь админа
        $user = new ActiveDataProvider([
            'query' => User::find()->andWhere(['id' => Yii::$app->user->id])
        ]);

        //отправь учителей
        $teachers = new ActiveDataProvider([
            'query' => Teacher::find()
                ->andWhere(['in', 'cafedra_id', Cafedra::find()
                    ->andWhere(['hs_id' => $hs])
                    ->select('id')])
                ->orderBy(['score' => SORT_DESC]),
            'pagination' => false
        ]);

        //отправь высшие школы
        $hss = new ActiveDataProvider([
            'query' => Highschool::find()->andWhere(['year' => date('Y')])
        ]);
        $hss2 = Highschool::find()->andWhere(['id' => $hs])->one();

        //отправь кнопки отчетов
        $reports = new ActiveDataProvider([
            'query' => Report::find()
        ]);

        return $this->render('admin', [
            'user' => $user,
            'teachers' => $teachers,
            'hss' => $hss,
            'hss2' => $hss2,
            'reports' => $reports,
            'btn' => $btn
        ]);
    }

    //принти пдфки
    public function actionReport($rid, $id)
    {
        if($rid == 'rb1'){
            $teacher = new ActiveDataProvider([
                'query' => Teacher::find()
                    ->andWhere(['in', 'cafedra_id', Cafedra::find()
                        ->andWhere(['hs_id' => $id])
                        ->select('id')])
                    ->orderBy(['score' => SORT_DESC])
            ]);
            $content = $this->renderPartial('teacher2', [
                'teacher' => $teacher
            ]);
        }
        else if($rid == 2){
            $teacher = new ActiveDataProvider([
                'query' => Teacher::find()
                    ->orderBy(['score' => SORT_DESC])
            ]);
            $content = $this->renderPartial('teacher', [
                'teacher' => $teacher
            ]);
        }else if($rid == 3){
            $hs = new ActiveDataProvider([
                'query' => Highschool::find()
                    ->andWhere(['year' => date('Y')])
                    ->select(['highschool.*',
                        new Expression('score + average as total')])
                    ->orderBy(['total' => SORT_DESC])
            ]);
            $content = $this->renderPartial('hs2', [
                'hs' => $hs
            ]);
        }
        else if($rid == 4){
            $hs = new ActiveDataProvider([
                'query' => Highschool::find()
                    ->andWhere(['year' => date('Y')])
                    ->select(['highschool.*',
                        new Expression('score + average as total')])
                    ->orderBy(['total' => SORT_DESC])
            ]);
            $content = $this->renderPartial('hs', [
                'hs' => $hs
            ]);
        }
        else{
            return $this->redirect(['admin',
                'btn' => 'rb'.$rid,
                'hs' => ''
            ]);
        }
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}'
        ]);
        return $pdf->render();
    }
}