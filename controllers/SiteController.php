<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Job;
use app\models\User;
use app\models\System;
use app\models\Employee;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['lang'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
		if (!\Yii::$app->user->isGuest){

			$this->auth();

		}else{

			return $this->render('index');
		}


    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest){
            $this->auth();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

              $this->auth();

        }else{

			 return $this->render('login', [
                'model' => $model,
			]);
		}

    }


    public function auth(){

        if (!\Yii::$app->user->isGuest){

          if(Yii::$app->user->identity->role == 'user'){

             Yii::$app->session->set('isUser', true);

             return $this->redirect(['/user-request/index']);
          }

          if(Yii::$app->user->identity->role == 'admin' || Yii::$app->user->identity->role == 'support' ){
             return $this->redirect(['/job/index']);
          }

       }

    }

    public function actionRegister()
    {

        if (!\Yii::$app->user->isGuest){
            $this->auth();
        }

        $model = new Employee();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(!empty($model->password)){
                $model->setPassword($model->password);
            }

            $model->save();

            Yii::$app->getSession()->setFlash('registerSuccess');

            return $this->redirect(['login']);

        } else {

            $login_required = System::findOne(1);

            return $this->render('register', [
                'model' => $model,
                'login_required' => $login_required->login_required,
            ]);
        }
    }

    public function actionRegisterSuccess(){

      return $this->render('index');

    }

    public function actionLogout()
    {

        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    public function actionLang(){

        return $this->redirect(['index']);
    }


}
