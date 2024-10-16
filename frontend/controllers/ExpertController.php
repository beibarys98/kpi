<?php

namespace frontend\controllers;

use common\models\Admin;
use common\models\Cafedra;
use common\models\Category;
use common\models\Criteria;
use common\models\EtCtg;
use common\models\Expert;
use common\models\File;
use common\models\Highschool;
use common\models\Manager;
use common\models\Teacher;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ExpertController extends Controller
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

    //эксперты оценивают здесь
    public function actionExpert($btn = '', $hs = '')
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        //отправляю самого эксперта, чтобы показать его/ее имя
        $user = new ActiveDataProvider([
            'query' => User::find()->andWhere(['id' => Yii::$app->user->id])
        ]);

        //отправляю учителей
        $teachers = new ActiveDataProvider([
            'query' => Teacher::find()
                ->andWhere(['in', 'cafedra_id', Cafedra::find()
                    ->andWhere(['hs_id' => $hs])
                    ->select('id')])
                ->orderBy(['score' => SORT_DESC]),
            'pagination' => false
        ]);

        //отправляю высшие школы
        $hss = new ActiveDataProvider([
            'query' => Highschool::find()->andWhere(['year' => date('Y')])
        ]);
        $hss2 = Highschool::find()->andWhere(['id' => $hs])->one();

        return $this->render('expert', [
            'user' => $user,
            'teachers' => $teachers,
            'hss' => $hss,
            'hss2' => $hss2,
            'btn' => $btn
        ]);
    }

    //оценивает учителей здесь
    public function actionTrating($ctg = '', $crit = '', $uid = '')
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        //отправляю учителя
        $user = new ActiveDataProvider([
            'query' => User::find()->andWhere(['id' => $uid])
        ]);

        //отправляю категории
        if(Admin::findOne(['user_id' => Yii::$app->user->id])){
            $category = new ActiveDataProvider([
                'query' => Category::find()->andWhere(['type' => 1])
            ]);
        }else{
            $category = new ActiveDataProvider([
                'query' => Category::find()
                    ->andWhere(['type' => 1])
                    ->andWhere(['in', 'id', EtCtg::find()
                        ->andWhere(['expert_id' => Expert::find()
                            ->andWhere(['user_id' => Yii::$app->user->id])
                            ->one()->id])
                        ->select('category_id')])
            ]);
        }
        $category2 = Category::find()->andWhere(['id' => $ctg])->one();

        //отправляю критерии
        $criteria = new ActiveDataProvider([
            'query' => Criteria::find()->andWhere(['category_id' => $ctg])
        ]);
        $criteria2 = Criteria::find()->andWhere(['id' => $crit])->one();

        //отправляю сохраненные файлы
        $files = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['created_by' => $uid, 'criteria_id' => $crit])
                ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => false
        ]);

        return $this->render('trating', [
            'user' => $user,
            'category' => $category,
            'category2' => $category2,
            'criteria' => $criteria,
            'criteria2' => $criteria2,
            'files' => $files
        ]);
    }

    //оценивает высшие школы
    public function actionCrating($ctg = '', $crit = '', $hs = '')
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        //отправляю высшую школу
        $hss = new ActiveDataProvider([
            'query' => Highschool::find()->andWhere(['id' => $hs])
        ]);
        $hss2 = Highschool::find()->andWhere(['id' => $hs])->one();

        //высчитываю kpi
        $teachers = new ActiveDataProvider([
            'query' => Teacher::find()
                ->andWhere(['in', 'cafedra_id', Cafedra::find()
                    ->andWhere(['hs_id' => $hs])
                    ->select('id')])
        ]);
        $sum = 0;
        foreach ($teachers->query->all() as $teacher){
            $sum += $teacher->score;
        }
        $hss2->average = $sum / $teachers->query->count();
        $hss2->save();

        //отправляю категории
        if(Admin::find()->andWhere(['user_id' => Yii::$app->user->id])->one()){
            $category = new ActiveDataProvider([
                'query' => Category::find()->andWhere(['type' => 2])
            ]);
        }else{
            $category = new ActiveDataProvider([
                'query' => Category::find()
                    ->andWhere(['type' => 2])
                    ->andWhere(['in', 'id', EtCtg::find()
                        ->andWhere(['expert_id' => Expert::find()
                            ->andWhere(['user_id' => Yii::$app->user->id])
                            ->one()->id])
                        ->select('category_id')])
            ]);
        }
        $category2 = Category::find()->andWhere(['id' => $ctg])->one();

        //отправляю критерии
        $criteria = new ActiveDataProvider([
            'query' => Criteria::find()->andWhere(['category_id' => $ctg])
        ]);
        $criteria2 = Criteria::find()->andWhere(['id' => $crit])->one();

        //отправляю файлы
        $files = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['criteria_id' => $crit])
                ->andWhere(['created_by' => Manager::find()
                    ->andWhere(['in', 'cafedra_id', Cafedra::find()
                        ->andWhere(['hs_id' => $hs])
                        ->select('id')])
                    ->select('user_id')])
                ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => false
        ]);

        return $this->render('crating', [
            'hss' => $hss,
            'category' => $category,
            'category2' => $category2,
            'criteria' => $criteria,
            'criteria2' => $criteria2,
            'files' => $files
        ]);
    }

    //принять файлы здесь
    public function actionPlus($id, $crit, $view){
        $file = File::find()->andWhere(['id' => $id])->one();
        $user = User::find()->andWhere(['id' => $file->created_by])->one();
        $criteria = Criteria::find()->andWhere(['id' => $crit])->one();

        //если менеджер, добавь баллы высшей школе
        if(Manager::find()->andWhere(['user_id' => $user->id])->one()){
            $model = Highschool::find()
                ->andWhere(['in', 'id', Cafedra::find()
                    ->andWhere(['in', 'id', Manager::find()
                        ->andWhere(['user_id' => $user->id])
                        ->select('cafedra_id')])
                    ->select('hs_id')])->one();
            if($file->status != 'принято'){
                $model->score += $criteria->points;
                $file->status = 'принято';
            }

        //если учитель, добавь баллы учителю
        }else{
            $model = Teacher::find()->andWhere(['user_id' => $user->id])->one();
            if($file->status != 'принято'){
                if($criteria->category_id == 1 || $criteria->category_id == 6){
                    $model->score += $criteria->points;
                }else{
                    $model->score += 1.5 * $criteria->points;
                }
                $model->save();

                //высчитываю kpi
                $hss2 = Highschool::find()
                    ->andWhere(['id' => Cafedra::find()
                        ->andWhere(['id' => $model->cafedra_id])
                        ->select('hs_id')])->one();
                $teachers = new ActiveDataProvider([
                    'query' => Teacher::find()
                        ->andWhere(['in', 'cafedra_id', Cafedra::find()
                            ->andWhere(['hs_id' => $hss2->id])
                            ->select('id')])
                ]);
                $sum = 0;
                foreach ($teachers->query->all() as $teacher){
                    $sum += $teacher->score;
                }
                $hss2->average = $sum / $teachers->query->count();
                $hss2->save();

                $file->status = 'принято';
            }
        }

        //если оцениваешь учителя, вернись на эту страницу
        if($view == 'trating'){
            if($file->save(false) && $model->save()){
                return $this->redirect([$view,
                        'ctg' => $criteria->category_id,
                        'crit' => $crit,
                        'uid' => $user->id]);
            }
            return $this->redirect([$view,
                'ctg' => $criteria->category_id,
                'crit' => $crit,
                'uid' => $user->id]);
        }

        //если оцениваешь менеджера, вернись на эту страницу
        else{
            $hs = Highschool::find()
                ->andWhere(['in', 'id', Cafedra::find()
                    ->andWhere(['in', 'id', Manager::find()
                        ->andWhere(['user_id' => $user->id])
                        ->select('cafedra_id')])
                    ->select('hs_id')])->one();
            if($file->save(false) && $model->save()){
                return $this->redirect([$view,
                    'ctg' => $criteria->category_id,
                    'crit' => $crit,
                    'hs' => $hs->id]);
            }
            return $this->redirect([$view,
                'ctg' => $criteria->category_id,
                'crit' => $crit,
                'hs' => $hs->id]);
        }

    }

    //отклонить файлы здесь
    public function actionMinus($id, $crit, $view){
        $file = File::find()->andWhere(['id' => $id])->one();
        $user = User::find()->andWhere(['id' => $file->created_by])->one();
        $criteria = Criteria::find()->andWhere(['id' => $crit])->one();

        //если менеджер, отними баллы высшей школы
        if(Manager::find()->andWhere(['user_id' => $user->id])->one()){
            $model = Highschool::find()
                ->andWhere(['in', 'id', Cafedra::find()
                    ->andWhere(['in', 'id', Manager::find()
                        ->andWhere(['user_id' => $user->id])
                        ->select('cafedra_id')])
                    ->select('hs_id')])->one();
            if($file->status == 'ожидает'){
                $file->status = 'отклонено';
            }else{
                $model->score -= $criteria->points;
                $file->status = 'отклонено';
            }

        //если учитель, отними баллы учителя
        }else{
            $model = Teacher::find()->andWhere(['user_id' => $user->id])->one();
            if($file->status == 'ожидает'){
                $file->status = 'отклонено';
            }else{
                if($criteria->category_id == 1 || $criteria->category_id == 6){
                    $model->score -= $criteria->points;
                }else{
                    $model->score -= 1.5 * $criteria->points;
                }

                //высчитываю kpi
                $hss2 = Highschool::find()
                    ->andWhere(['id' => Cafedra::find()
                        ->andWhere(['id' => $model->cafedra_id])
                        ->select('hs_id')])->one();
                $teachers = new ActiveDataProvider([
                    'query' => Teacher::find()
                        ->andWhere(['in', 'cafedra_id', Cafedra::find()
                            ->andWhere(['hs_id' => $hss2->id])
                            ->select('id')])
                ]);
                $sum = 0;
                foreach ($teachers->query->all() as $teacher){
                    $sum += $teacher->score;
                }
                $hss2->average = $sum / $teachers->query->count();
                $hss2->save();

                $file->status = 'отклонено';
            }
        }

        //если оцениваешь учителя, вернись на эту страницу
        if($view == 'trating'){
            if($file->save(false) && $model->save()){
                return $this->redirect([$view,
                    'ctg' => $criteria->category_id,
                    'crit' => $crit,
                    'uid' => $user->id]);
            }
            return $this->redirect([$view,
                'ctg' => $criteria->category_id,
                'crit' => $crit,
                'uid' => $user->id]);
        }

        //если оцениваешь менеджера, вернись на эту страницу
        else{
            $hs = Highschool::find()
                ->andWhere(['in', 'id', Cafedra::find()
                    ->andWhere(['in', 'id', Manager::find()
                        ->andWhere(['user_id' => $user->id])
                        ->select('cafedra_id')])
                    ->select('hs_id')])->one();
            if($file->save(false) && $model->save()){
                return $this->redirect([$view,
                    'ctg' => $criteria->category_id,
                    'crit' => $crit,
                    'hs' => $hs->id]);
            }
            return $this->redirect([$view,
                'ctg' => $criteria->category_id,
                'crit' => $crit,
                'hs' => $hs->id]);
        }
    }
}