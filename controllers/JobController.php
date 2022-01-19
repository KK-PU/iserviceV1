<?php

namespace app\controllers;

use Yii;
use app\models\Job;
use app\models\JobSearch;
use app\models\Employee;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use yii\web\UploadedFile;

class JobController extends Controller
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
                  'actions'=>['index','create','update','delete','search-status','print','doc-number'],
                  'allow'=>true,
                  'roles'=>[
                    'support'
                  ],
                ],
      					[
      						'actions'=>['print'],
      						'allow'=>true,
      						'roles'=>['?','user'],
      					],
      				]
      			]
        ];
    }

    /**
     * Lists all Job models.
     * @return mixed
     */
    public function actionIndex(){

        $start_search = Yii::$app->request->get('start_search',date("Y-m-")."01");

        $end_search = Yii::$app->request->get('end_search',date("Y-m-d"));

        $page = Yii::$app->request->get('page',1);

        $query = Job::find()->where('DATE(job_date) BETWEEN "'.$start_search.'" AND "'.$end_search.'"');

        if(Yii::$app->user->identity->role == 'support'){
              $query->andWhere(['user_id' => Yii::$app->user->identity->id])
                    ->orWhere(['job_status' => 'request']);
          }

        $query->orderBy(['job_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                //'pagination'=>false,
                'sort' =>false
        ]);

        return $this->render('index', [
                'start_search' => $start_search,
                'end_search' => $end_search,
                'page' => $page,
                'dataProvider' => $dataProvider,
                'countAll'=> $query->count(),
                'title'=>" ".Yii::$app->datethai->getDate($start_search)."&nbsp;".Yii::t('app','to')."&nbsp;".Yii::$app->datethai->getDate($end_search),
        ]);

    }

    public function actionSearchStatus($status){
        //show data for search date
        $query = Job::find()
    		->where(['job_status'=>$status]);

        if($status != 'request'){
            if(Yii::$app->user->identity->role == 'support'){
                $query->andWhere(['user_id' => Yii::$app->user->identity->id]);
            }
        }

    		$query->orderBy(['job_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
            'sort' =>false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'countAll'=> $query->count(),
            'title'=> Yii::$app->getdata->getStatus($status),
            'start_search' => date("Y-m-")."01",
            'end_search' => date("Y-m-d"),
            'page' => '1',
        ]);
    }

    public function actionPrint($id)
    {

        $this->layout = "print";

        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);

    }

    public function actionPrintDevice($id)
    {
        $this->layout = "print";
        return $this->render('print-request-device', [
            'model' => $this->findModel($id),
        ]);
    }

    public function getDocNumber(){

      $number = Job::find()->select('MAX(job_number) as job_number')
      ->where(['MONTH(job_date)'=>date("m"),'YEAR(job_date)' => date("Y")])
      ->One();

      if(!empty($number->job_number)){
         return $number->job_number + 1;
      }else{
        return date("Ym").'001' + 0;
      }
    }


    public function actionCreate() {

        $model = new Job();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->job_number = $this->getDocNumber();

            $model->request_file = Yii::$app->upload->uploadMultiple($model,'request_file');

            $model->success_file = Yii::$app->upload->uploadMultiple($model,'success_file');

            if($model->save()){

                  $this->sendMailTo($model);

                 try{
                   $job_date = Job::getDateTime($model->job_date);

                   $user_fullname = !empty($model->employee->user_fullname) ? $model->employee->user_fullname : '';

                   $department = !empty($model->employee->department->department_name) ? $model->employee->department->department_name : '';

                   $job_detail =  !empty($model->job_detail) ? $model->job_detail : '';

                   $device_name = !empty($model->device->device_name) ? $model->device->device_name : '';

                   $phone = !empty($model->phone) ? $model->phone : '';

                   $msg = "\n".Yii::t('app','job_request_date')." :  ".$job_date."\n";
                   $msg .= Yii::t('app','staff')." :  ".$user_fullname."\n";
                   $msg .= Yii::t('app','department_name')."  : ".$department;

                   if(!empty($phone)){
                       $msg .= "\n".Yii::t('app','phone')." : ".$phone;
                   }

                   if(!empty($device_name)){
                     $msg.= "\n".Yii::t('app','device_name')." :  ".$device_name;
                   }

                   $msg .= "\n".Yii::t('app','problem')." : ".$job_detail."\n";

                   $this->notify_message($msg);

                 }catch(\Swift_TransportException $e){

                 }

            }

            //show alert
            Yii::$app->getSession()->setFlash('save');

            return $this->redirect(['index',
                'start_search' => Yii::$app->formatter->asDate($model->job_date, 'php:Y-m-')."01",
                'end_search' => Yii::$app->formatter->asDate($model->job_date, 'php:Y-m-d'),
            ]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
      	//get date search
        $start_search = Yii::$app->request->get('start_search',date("Y-m-")."01");

        $end_search = Yii::$app->request->get('end_search',date("Y-m-d"));

        $page = Yii::$app->request->get('page',1);

        $id = Yii::$app->request->get('id');

      	$model = $this->findModel($id);

        $request_file_old = $model->request_file;

        $success_file_old = $model->success_file;

        $old_status = $model->job_status;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->request_file = Yii::$app->upload->uploadMultiple($model,'request_file');

            $model->success_file = Yii::$app->upload->uploadMultiple($model,'success_file');

            if(Yii::$app->user->identity->role == 'support' && $old_status != 'success' && $model->job_status == 'success'){
                $model->job_success_date = date("Y-m-d H:i:s");
            }

            $model->save();

            if($old_status != 'success' && $model->job_status == 'success' || $model->job_status == 'wait' || $model->job_status == 'claim' || $model->job_status == 'process' || $model->job_status == 'cancel'){

                $this->SendMailTo($model,$model->job_employee_id);
            }

            Yii::$app->getSession()->setFlash('save');

            return $this->redirect(['index',
                'start_search'=>$start_search,
                'end_search'=>$end_search,
                'page' => $page
            ]);

        } else {
            return $this->render('update', [
                'model' => $model,
                'start_search'=>$start_search,
                'end_search'=>$end_search,
                'page' => $page
            ]);
        }
    }

    /**
     * Deletes an existing Job model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id){

      	$start_search = Yii::$app->request->get('start_search');

      	$end_search = Yii::$app->request->get('end_search');

        $model = $this->findModel($id);

        $file_request = $model->request_file;

        $file_success = $model->success_file;

        $model->delete();

        $this->deleteFile($model->getUploadPath().$file_request);

        $this->deleteFile($model->getUploadPath().$file_success);


        Yii::$app->getSession()->setFlash('delete');

    		return $this->redirect(['index',
    			'start_search'=>$start_search,
    			'end_search'=>$end_search
    		]);
    }


    public function deleteFile($path = null) {

        if (!@unlink($path)) {
            echo ("Error deleting $path");
        }
    }

    public function SendMailTo($model = null , $employee_id = null){

        $user_email = Employee::findOne($employee_id);

          if(!empty($user_email->user_email)){

            try{
              Yii::$app->mailer->compose('@app/mail/layouts/complete',[
                'model'=>$model
              ])
              ->setFrom([Yii::$app->params['adminEmail']=> Yii::t('app','email_title')])
              ->setTo($user_email->user_email)
              ->setSubject(Yii::t('app','email_success_message')." ".date("Y/m/d"))
              ->send();

            }catch(\Swift_TransportException $e){

            }

          }


    }


    public function notify_message($message)
      {
          $line_api = 'https://notify-api.line.me/api/notify';

          $line_token =  Yii::$app->params['line_token'];

          if($line_token != ''){

                  $queryData = array('message' => $message);
                  $queryData = http_build_query($queryData,'','&');
                  $headerOptions = array(
                      'http'=>array(
                          'method'=>'POST',
                          'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                              ."Authorization: Bearer ".$line_token."\r\n"
                              ."Content-Length: ".strlen($queryData)."\r\n",
                          'content' => $queryData
                      )
                  );
                  $context = stream_context_create($headerOptions);
                  $result = @file_get_contents($line_api, FALSE, $context);
                  $res = json_decode($result);
                  return $res;
          }
      }

    public function actionDeleteRequestFile(){

      $name = Yii::$app->request->get('name');

       $id = Yii::$app->request->get('id');

       $job = $this->findModel($id);

       $path = Yii::$app->upload->getUploadPath();

       $image_arr = explode(",", $job->request_file);

       $result = array_diff($image_arr,[$name]);

       $file = implode(",",$result);

       $job->request_file = $file;

       $job->save();

       $this->deleteFile($path.$name);

       return $this->redirect(['update', 'id' => $id]);

    }


    public function actionDeleteSuccessFile(){

      $name = Yii::$app->request->get('name');

       $id = Yii::$app->request->get('id');

       $job = $this->findModel($id);

       $path = Yii::$app->upload->getUploadPath();

       $image_arr = explode(",", $job->success_file);

       $result = array_diff($image_arr,[$name]);

       $file = implode(",",$result);

       $job->success_file = $file;

       $job->save();

       $this->deleteFile($path.$name);

       return $this->redirect(['update', 'id' => $id]);

    }


    /**
     * Finds the Job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Job the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
