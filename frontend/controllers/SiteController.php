<?php

namespace frontend\controllers;

use common\models\Admin;
use common\models\Category;
use common\models\Control;
use common\models\Criteria;
use common\models\Expert;
use common\models\File;
use common\models\Link;
use common\models\Manager;
use common\models\Teacher;
use common\models\User;
use frontend\models\ResetPasswordForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\UploadedFile;

class SiteController extends Controller
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
                    ]
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

    //учителя и менеджеры загружают файлы здесь
    public function actionIndex($ctg = '', $crit = '')
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        //отправляю самого учителя/менеджера чтобы показывать его/ее имя и kpi
        $user = new ActiveDataProvider([
            'query' => User::find()->andWhere(['id' => Yii::$app->user->id])
        ]);

        //отправляю категории для учителей/менеджеров
        if(Manager::find()->andWhere(['user_id' => Yii::$app->user->id])->one()){
            $category = new ActiveDataProvider([
                'query' => Category::find()->andWhere(['type' => 2])
            ]);
        }else{
            $category = new ActiveDataProvider([
                'query' => Category::find()->andWhere(['type' => 1])
            ]);
        }
        $category2 = Category::find()->andWhere(['id' => $ctg])->one();

        //отправляю критерии
        $criteria = new ActiveDataProvider([
            'query' => Criteria::find()
                ->andWhere(['category_id' => $ctg])
        ]);
        $criteria2 = Criteria::find()->andWhere(['id' => $crit])->one();

        //сохраняю файл
        $newFile = new File();
        $link = new Link();
        $formData = Yii::$app->request->post();

        if ($newFile->load($formData)) {
            $uploadedFile = UploadedFile::getInstance($newFile, 'newFile');

            $filePath = Yii::getAlias('@frontend/web/uploads/')
                . User::find()->andWhere(['id' => Yii::$app->user->id])->one()->username . '_'
                . date('Y_m_d_H_i_s')
                . '.' . $uploadedFile->extension;

            if($uploadedFile->saveAs($filePath)){
                $newFile->criteria_id = $crit;
                $newFile->file_path = $filePath;
                $newFile->status = 'ожидает';
                $newFile->save(false);
            }

            if (strpos(Criteria::find()
                    ->andWhere(['id' => $newFile->criteria_id])
                    ->one()->condition, 'ссылка на') !== false) {

                if ($link->load($formData)) {
                    $link->file_id = $newFile->id;
                    $link->save(false);
                }
            }

            return $this->redirect(['index', 'ctg' => $ctg, 'crit' => $crit]);
        }

        //отправляю сохраненные файлы
        $files = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['created_by' => Yii::$app->user->id, 'criteria_id' => $crit])
                ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => false
        ]);

        return $this->render('index', [
            'user' => $user,
            'category' => $category,
            'category2' => $category2,
            'criteria' => $criteria,
            'criteria2' => $criteria2,
            'newFile' => $newFile,
            'files' => $files,
            'link' => $link
        ]);
    }

    public function actionPost()
    {
        $pendingFiles = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['created_by' => Yii::$app->user->id])
                ->andWhere(['status' => 'ожидает']),
            'pagination' => false
        ]);

        $acceptedFiles = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['created_by' => Yii::$app->user->id])
                ->andWhere(['status' => 'принято']),
            'pagination' => false
        ]);

        $declinedFiles = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['created_by' => Yii::$app->user->id])
                ->andWhere(['status' => 'отклонено']),
            'pagination' => false
        ]);

        return $this->render('post', [
            'pendingFiles' => $pendingFiles,
            'acceptedFiles' => $acceptedFiles,
            'declinedFiles' => $declinedFiles
        ]);
    }

    //скачивают файлы здесь
    public function actionDownload($id){
        $model = File::find()->andWhere(['id' => $id])->one();

        return Yii::$app
            ->response
            ->sendFile($model->file_path, $model->file.'.pdf',
                ['inline' => 'true']);
    }

    //удаляют файлы здесь
    public function actionDelete($id)
    {
        $file = File::find()->andWhere(['id' => $id])->one();
        $crit = Criteria::find()->andWhere(['id' => $file->criteria_id])->one();
        $ctg = Category::find()->andWhere(['id' => $crit->category_id])->one();
        unlink($file->file_path);
        if(Link::find()->andWhere(['file_id' => $id])->one()){
            $link = Link::find()->andWhere(['file_id' => $id])->one();
            $link->delete();
        }
        $file->delete();

        return $this->redirect(['index', 'ctg' => $ctg->id, 'crit' => $crit->id]);
    }

    //логинятся здесь
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest){
            Yii::$app->user->logout();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $admin = Admin::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
            $expert = Expert::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
            $manager = Manager::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
            $teacher = Teacher::find()->andWhere(['user_id' => Yii::$app->user->id])->one();

            if($admin) {
                return $this->redirect(['/admin/admin', 'btn' => '', 'hs' => '']);
            }
            if($expert && Control::find()->one()->expert == 1){
                return $this->redirect(['/expert/expert', 'btn' => '', 'hs' => '']);
            }
            if($manager && Control::find()->one()->manager == 1){
                return $this->redirect(['index', 'ctg' => '', 'crit' => '']);
            }
            if($teacher && Control::find()->one()->teacher == 1){
                return $this->redirect(['index', 'ctg' => '', 'crit' => '']);
            }else{
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('danger', 'База закрыта!');
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    //логаутятся здесь
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }

    //меняют пароль здесь
    public function actionResetPassword()
    {
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post())
            && $model->validate()
            && $model->resetPassword()) {

            return $this->redirect(['login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    //меняют язык здесь
    public function actionLanguage($view)
    {
        if(Yii::$app->language == 'kz-KZ'){
            Yii::$app->session->set('language', 'ru-RU');
        }else{
            Yii::$app->session->set('language', 'kz-KZ');
        }
        return $this->redirect([$view]);
    }
}