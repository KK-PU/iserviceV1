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
use yii\filters\AccessControl;
use app\components\AccessRule;

class RequestController extends \yii\web\Controller
{

  public function behaviors(){

      return [
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'delete' => ['POST'],
              ],
          ],
      ];
  }

    public function actionIndex(){

		$model = new Job();

		if ($model->load(Yii::$app->request->post())) {

			$query = Job::find()->where(['job_employee_id'=>$model->job_employee_id])->orderBy(['job_date' => SORT_DESC]);

        }else{

			$query = Job::find()->orderBy(['job_date' => SORT_DESC]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=>false,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'model'=>$model
		]);
    }

	public function actionSearchStatus($status){
        //show data for search date
        $query = Job::find()->where(['job_status'=>$status])->orderBy('job_date ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
            'sort' =>false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'countAll'=> $query->count(),
            'title'=> $status == 'wait' ? 'สถานะ : รอตรวจสอบ'  : 'สถานะ : กำลังดำเนินการ',
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
            ->setFrom([Yii::$app->params['adminEmail']=> Yii::$app->params['email_send_from']])
						->setTo($user->email)
						->setSubject(Yii::$app->params['email_subject'])
						->send();

					}catch(\Swift_TransportException $e){


					}

				}
			}
		}

	}


  public function notify_message($message)
    {
        $line_api = 'https://notify-api.line.me/api/notify';

        if(!empty(Yii::$app->params['line_token'])){

          $queryData = array('message' => $message);
          $queryData = http_build_query($queryData,'','&');
          $headerOptions = array(
              'http'=>array(
                  'method'=>'POST',
                  'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                      ."Authorization: Bearer ".Yii::$app->params['line_token']."\r\n"
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

	public function actionView($id = null){

		$model = Job::findOne($id);

		return $this->renderAjax('view',['model'=>$model]);

	}

	public function actionPrint($id = null){

		$this->layout = "print";

		$model = Job::findOne($id);

		return $this->render('print',['model'=>$model]);

	}


	public function actionGetDevice() {

		$out = [];

		if (isset($_POST['depdrop_parents'])) {

			$parents = $_POST['depdrop_parents'];

			if ($parents != null) {

					$id = $parents[0];

					$emp_department = Employee::findOne($id);

					$list = Device::find()->select('id,device_name')
					->select(['id,CONCAT_WS("",device_id," - ",device_name) AS device_name'])
					->where(['department_id'=>$emp_department->department_id])
					->andWhere(['device_status'=>'enable'])
					->All();

					$selected = '';

					foreach ($list as $i => $account) {

						$out[] = ['id' => $account['id'], 'name' => $account['device_name']];
					}

					echo Json::encode(['output'=>$out, 'selected'=>'']);
					return;
				}
			}

        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

}
