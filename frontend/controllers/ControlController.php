<?php

namespace frontend\controllers;

use common\models\Control;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ControlController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Control::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOn($tgl)
    {
        $control = Control::find()->one();

        if($tgl == 't'){
            $control->teacher = 1;
        }else if($tgl == 'm'){
            $control->manager = 1;
        }else if($tgl == 'e'){
            $control->expert = 1;
        }

        $control->save();
        return $this->redirect(['index']);
    }

    public function actionOff($tgl)
    {
        $control = Control::find()->one();

        if($tgl == 't'){
            $control->teacher = 0;
        }else if($tgl == 'm'){
            $control->manager = 0;
        }else if($tgl == 'e'){
            $control->expert = 0;
        }

        $control->save();
        return $this->redirect(['index']);
    }
}
