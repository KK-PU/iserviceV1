<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;


/**
 * UserController implements the CRUD actions for User model.
 */

class UserController extends Controller
{

    public function behaviors(){

        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access'=>[
              'class'=>AccessControl::className(),
              'ruleConfig' =>[
                  'class' => AccessRule::className(),
              ],
              'rules'=>[
                [
                  'allow' => true,
                  'roles' => [
                      'admin',
                   ],
                ],
                [
                  'allow' => true,
                  'actions' =>['edit-profile'],
                  'roles' => [
                      'support',
                   ],
                ],
              ]
            ]
        ];
    }


    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new User();
		
		$model->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(!empty($model->password)){
                $model->setPassword($model->password);
            }

            $model->save();
              Yii::$app->getSession()->setFlash('save');

              return $this->redirect(['index']);

        }else{

          return $this->render('create', [
              'model' => $model,
          ]);

        }


    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(!empty($model->password)){

                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            }

            $model->save();

            Yii::$app->getSession()->setFlash('save');

            return $this->redirect(['index']);

        } else {

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

            //show alert
            Yii::$app->getSession()->setFlash('delete');

        return $this->redirect(['index']);
    }


    public function actionEditProfile(){


        $model = $this->findModel(Yii::$app->user->identity->id);

        $model->scenario = 'update_profile';

        if ($model->load(Yii::$app->request->post()) && $model->editUserProfile()) {

            Yii::$app->getSession()->setFlash('save_user_profile');

            return $this->redirect(['edit-profile']);

        }else{

            return $this->render('edit-profile', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
