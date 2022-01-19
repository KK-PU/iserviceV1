<?php

namespace app\controllers;

use Yii;
use app\models\Device;
use app\models\Job;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\filters\AccessControl;
use app\components\AccessRule;
/**
 * DeviceController implements the CRUD actions for Device model.
 */
class DeviceController extends Controller
{
    public function behaviors() {
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
                      'support'
                   ],
                ],
              ]
            ]
        ];
    }

    /**
     * Lists all Device models.
     * @return mixed
     */
    public function actionIndex(){

        $model = new Device();

        $query = Device::find()->where(['device_status'=>'enable'])
		      ->orderBy('device_type_id,device_id,department_id ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>false,
        ]);

        return $this->render('index', [
            'model' => $model,
            'get_select' =>NULL,
            'dataProvider' => $dataProvider,
			      'active'=>'device_id'
        ]);

    }

    public function actionSearchDevice(){

            $get_select = Yii::$app->request->get('Device');

            $device_type_id = $get_select['device_type_id'];

            $department_id = $get_select['department_id'];

            if($device_type_id == 0 && $department_id == 0){
                //all device type
                $query = Device::find()
                ->orderBy('department_id,device_type_id ASC');

            }else if($device_type_id == 0){

                $query = Device::find()
                ->where(['department_id'=>$department_id])
               ->orderBy('department_id,device_type_id ASC');

            }else if($department_id == 0){

                $query = Device::find()
                ->where(['device_type_id'=>$device_type_id])
                ->orderBy('department_id,device_type_id ASC');

            }else{

                $query = Device::find()
                ->where(['department_id'=>$department_id,'device_type_id'=>$device_type_id])
               ->orderBy('department_id,device_type_id ASC');
            }


            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=>false,
            ]);

        //return $this->renderPartial('index', [
        return $this->render('index', [
            'model' => new Device(),
            'get_select'=> $get_select,
            'dataProvider' => $dataProvider,
			      'active'=>'device_type'
        ]);
    }

	public function actionSearchId(){

            $get_select = Yii::$app->request->get('Device');

            $query = Device::find()->where(['device_id'=>$get_select['device_id']]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=>false,
            ]);

        //return $this->renderPartial('index', [
        return $this->render('index', [
            'model' => new Device(),
            'get_select'=> NULL,
            'dataProvider' => $dataProvider,
			      'active'=>'device_id'
        ]);
    }

	public function actionDeviceName(){

            $get_select = Yii::$app->request->get('Device');

            $query = Device::find()->where(['id'=>$get_select['id']]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=>false,
            ]);

        //return $this->renderPartial('index', [
        return $this->render('index', [
            'model' => new Device(),
            'get_select'=> NULL,
            'dataProvider' => $dataProvider,
			      'active'=>'device_name'
        ]);
    }


	public function actionDeviceSn(){

            $get_select = Yii::$app->request->get('Device');

            $query = Device::find()->where(['serial_no'=>$get_select['serial_no']]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=>false,
            ]);

        //return $this->renderPartial('index', [
        return $this->render('index', [
            'model' => new Device(),
            'get_select'=> NULL,
            'dataProvider' => $dataProvider,
			      'active'=>'serial_no'
        ]);
    }

	public function actionDeviceEmployee(){

            $get_select = Yii::$app->request->get('Device');

            $query = Device::find()->where(['employee_id'=>$get_select['employee_id']]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=>false,
            ]);

        //return $this->renderPartial('index', [
        return $this->render('index', [
            'model' => new Device(),
            'get_select'=> NULL,
            'dataProvider' => $dataProvider,
			         'active'=>'employee_id'
        ]);
    }

    public function actionDeviceStatus($status) {

      if($status == 'repair'){

		  $query = Device::find()
          ->innerJoin('job','device.id = job.device_id')
		  ->where(['not in','job.job_status',['success','cancel']]);

      }else if($status == 'total'){

        $query = Device::find();

      }else{

        $query = Device::find()->where(['device_status' => $status]);
      }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        return $this->render('index',[
            'model' => new Device(),
            'dataProvider'=>$dataProvider,
            'get_select'=> NULL,
			         'active'=>'device_id'

        ]);
    }

    /**
     * Displays a single Device model.
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
     * Creates a new Device model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Device();

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {

           $image = UploadedFile::getInstance($model,'image');

                if(!empty($image)){

                    $model->image = $model->upload($model,'image');

                }else{

                    $model->image = 'no_image.png';
                }

				if(isset($_POST['software'])){

					$software = $_POST['software'];

					$result = implode(",",$software);

					$model->software = $result;
				}

            $model->save();

            //show alert
            Yii::$app->getSession()->setFlash('save');

            //for search device
            return $this->redirect(['search-device',
                'Device[department_id]'=>$model->department_id,
                'Device[device_type_id]'=>$model->device_type_id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Device model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){

        $device = Yii::$app->request->get('Device');

        $page = Yii::$app->request->get('page');

        $model = $this->findModel($id);

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        $image_old = $model->image;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

              $model->image = Yii::$app->upload->uploadMultiple($model,'image');

      				if(isset($_POST['software'])){

      					$software = $_POST['software'];

      					$result = implode(",",$software);

      					$model->software = $result;

      				}else{

      					$model->software = NULL;
      				}

              if(isset($_POST['software_sn'])){

      					$model->software_sn = json_encode($_POST['software_sn']);
              }



            $model->save();

            //show alert
            Yii::$app->getSession()->setFlash('save');

                if($device != NULL){

                    //for search device page
                    return $this->redirect(['search-device',
                        'Device[department_id]'=>$device['department_id'],
                        'Device[device_type_id]'=>$device['device_type_id']]);
                }else{

                    return $this->redirect(['index', 'page' => $page]);
                }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }





    public function deleteImg($delete_path = null) {

        if (!@unlink($delete_path)) {
            echo ("Error deleting $delete_path");
        }
    }

    /**
     * Deletes an existing Device model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $device = Yii::$app->request->get('Device');

        $page = Yii::$app->request->get('page');

        $this->findModel($id)->delete();

        //show alert
        Yii::$app->getSession()->setFlash('delete');

        if($device != NULL){

            //for search device
            return $this->redirect(['search-device',
                'Device[department_id]'=>$device['department_id'],
                'Device[device_type_id]'=>$device['device_type_id']]);

        }else{

            return $this->redirect(['index', 'page' => $page]);
        }


    }

	public function actionViewHistory($id){

	    $this->layout = "print";

        $query = Job::find()->where(['device_id' => $id])->orderBy('job_date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort'=>false,
        ]);

        return $this->render('view_history', [
            'device' => Device::findOne($id),
            'dataProvider' => $dataProvider,
			'id'=>$id
        ]);
	}


	public function actionDeleteAll(){

		$delete_ids = explode(',', Yii::$app->request->post('ids'));

		Device::deleteAll(['in','id',$delete_ids]);

		return $this->redirect(['index']);

	}

  public function actionDeleteImage(){

    $name = Yii::$app->request->get('name');

    $id = Yii::$app->request->get('id');

    $device = $this->findModel($id);

    $path = Yii::$app->upload->getUploadPath();

    $image_arr = explode(",", $device->image);

    $result = array_diff($image_arr,[$name]);

    $device_image = implode(",",$result);

    $device->image = $device_image;

    $device->save();

    $this->deleteImg($path.$name);

    $this->deleteImg($path.'thumbnail/'.$name);

    return $this->redirect(['update', 'id' => $id]);

}

    /**
     * Finds the Device model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Device the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Device::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
