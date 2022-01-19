<?php

namespace app\controllers;

use yii;
use app\models\Request;
use app\models\Job;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\models\Device;
use app\models\Employee;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\components\AccessRule;

class UserRequestController extends \yii\web\Controller
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
                    'user',
                 ],
              ],
            ]
          ]
      ];
  }

  public function beforeAction($action)
   {
      $this->layout = 'user-request'; //your layout name
      return parent::beforeAction($action);
   }

    public function actionIndex(){

      $department_id = !empty(Yii::$app->user->identity->department_id) ? Yii::$app->user->identity->department_id : '';

      $query = Job::find();

      $query->joinWith('device');

      $query->innerJoin('employee','employee.id = job.job_employee_id AND employee.department_id = '.$department_id);

      $query->orderBy('job_date DESC');

  		$dataProvider = new ActiveDataProvider([
  			'query' => $query,
  			'sort'=>false,
  		]);

  		return $this->render('index', [
  			'dataProvider' => $dataProvider,
  			//'model'=> new Job()
  		]);

    }


	public function actionSearchStatus($status){

        $query = Job::find()
        ->where(['job_status'=>$status,'job_employee_id' => Yii::$app->user->identity->id ])
    		->orderBy(['job_date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
            'sort' =>false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'countAll'=> $query->count(),
            'title'=> Job::getStatus($status),
            'start_search' => date("Y-m-")."01",
            'end_search' => date("Y-m-d"),
            'page' => '1',
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


	public function actionFormRequest(){

	    $model = new Request();

      if ($model->load(Yii::$app->request->post()) && $model->validate()) {

              $model->request_file = Yii::$app->upload->uploadMultiple($model,'request_file');

               $model->job_number = $this->getDocNumber();

               $model->save();

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

            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->redirect(['index']);
        }

        return $this->render('form_request', [
            'model' => $model,
        ]);
	}



  public function actionUpdateRequest($id = null){

	    $model = Request::findOne($id);

      $file_old = $model->request_file;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

              $model->request_file = Yii::$app->upload->uploadMultiple($model,'request_file');

              $model->save();

            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->redirect(['index']);
        }

        return $this->render('form_request', [
            'model' => $model,
        ]);
	}

  public function actionDelete($id){

          Request::findOne($id)->delete();

          Yii::$app->getSession()->setFlash('delete');

          return $this->redirect(['index']);
  }


		//send email to admin
	public function SendMailTo($model){

	$user_email = User::find()->select('email')->All();

		if(!empty($user_email)){

			foreach($user_email as $user){

				if(!empty($user->email)){

					try{
						Yii::$app->mailer->compose('@app/mail/layouts/view',[
							'model'=>$model
						])
						->setFrom([Yii::$app->params['adminEmail']=> Yii::t('app','email_title')])
						->setTo($user->email)
						->setSubject(Yii::t('app','email_request_message').date("Y/m/d"))
						->send();

					}catch(\Swift_TransportException $e){


					}

				}
			}
		}

	}


  public function deleteFile($path = null) {

      if (!@unlink($path)) {
          echo ("Error deleting $path");
      }
  }


  public function actionDeleteRequestFile(){

    $name = Yii::$app->request->get('name');

     $id = Yii::$app->request->get('id');

     $job = Job::findOne($id);

     $path = Yii::$app->upload->getUploadPath();

     $image_arr = explode(",", $job->request_file);

     $result = array_diff($image_arr,[$name]);

     $file = implode(",",$result);

     $job->request_file = $file;

     $job->save();

     $this->deleteFile($path.$name);

     return $this->redirect(['update-request', 'id' => $id]);

  }


	public function actionView($id = null){
		$model = Job::findOne($id);
		return $this->renderAjax('view',['model'=>$model]);

	}

	public function actionPrint($id = null){

		$this->layout = "print";

		$model = Job::findOne($id);

		return $this->render('print',['model'=>$model]);

	}


  public function actionEditProfile(){

      $model = Employee::findOne(Yii::$app->user->identity->id);

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

}
