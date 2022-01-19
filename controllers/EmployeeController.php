<?php

namespace app\controllers;

use Yii;
use app\models\Employee;
use app\models\SearchEmployee;
use app\models\System;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;


/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{

  public function behaviors()
  {
      return [
          'access'=>[
              'class' => AccessControl::className(),
              'ruleConfig' =>[
                  'class' => AccessRule::className(),
              ],
              'rules' => [
                  [
                    'allow' => true,
                    'roles' => [
                        'admin',
                     ],
                  ],

              ]
          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'delete' => ['POST'],
              ],
          ],
      ];
  }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchEmployee();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $login_required = System::findOne(1);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'login_required' => $login_required->login_required,
        ]);
    }

    /**
     * Displays a single Employee model.
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(!empty($model->password)){
                $model->setPassword($model->password);
            }

            $model->save();

            //show alert
            Yii::$app->getSession()->setFlash('save');

            return $this->redirect(['index']);

        } else {

          $login_required = System::findOne(1);

            return $this->render('create', [
                'model' => $model,
                'login_required' => $login_required->login_required,
            ]);
        }
    }

    /**
     * Updates an existing Employee model.
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

            $login_required = System::findOne(1);

            return $this->render('update', [
                'model' => $model,
                'login_required' => $login_required->login_required,
            ]);
        }
    }

    /**
     * Deletes an existing Employee model.
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




    public function actionLoginRequired(){

        $required = Yii::$app->request->get('required');

        $system = System::findOne(1);
        $system->login_required = (int)$required;
        $system->save();

        return $this->redirect(['index']);

    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
