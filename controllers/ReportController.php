<?php
namespace app\controllers;

use Yii;
use app\models\Job;
use app\models\JobType;
use app\models\Device;
use app\models\DeviceType;
use app\models\Department;
use app\models\Employee;
use app\models\User;
use app\models\SoftwareDetail;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;

class ReportController extends \yii\web\Controller{


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
                        'support'
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

    public function actionIndex() {

        return $this->redirect(['job-report','start_date'=>date("Y-m-")."01",'end_date'=>date("Y-m-t")]);
    }

	//show job report
    public function actionJobReport() {

        $user_id = Yii::$app->request->get('user_id');

        $start = Yii::$app->request->get('start',date("Y-m-")."01");

        $end =  Yii::$app->request->get('end',date("Y-m-d"));

        $query = Job::find()
        ->where('DATE(job_date) BETWEEN "' .$start. '" AND "' .$end. '"');

        if(!empty($user_id)){

          $query->andWhere(['user_id'=>$user_id]);

          $get_name = User::findOne(Yii::$app->request->get('user_id'));

          $name = $get_name->fullname;

        }else{
            $name = "";
        }

        $query->orderBy('job_date ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        return $this->render('job_report', [
            'dataProvider' => $dataProvider,
            'user_id'=>Yii::$app->request->get('user_id'),
            'start'=>$start,
            'end'=>$end,
            'name'=> $name,
        ]);
    }

    public function actionJobPrint() {

        $this->layout = "print";

        $user_id = Yii::$app->request->get('user_id');

        $query = Job::find()
        ->where('DATE(job_date) BETWEEN "' . Yii::$app->request->get('start') . '" AND "' . Yii::$app->request->get('end') . '"');

        if(!empty($user_id)){

          $query->andWhere(['user_id'=>$user_id]);

          $get_name = User::findOne(Yii::$app->request->get('user_id'));

          $name = $get_name->fullname;

        }else{
            $name = "";
        }

        $query->orderBy('job_date ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('job_print', [
            'dataProvider' => $dataProvider,
            'user_id'=>Yii::$app->request->get('user_id'),
            'start'=>Yii::$app->request->get('start'),
            'end'=>Yii::$app->request->get('end'),
            'name'=>$name
        ]);
    }


	//show job chart report
    public function actionChartReport() {

    $start = Yii::$app->request->get('start');
    $end = Yii::$app->request->get('end');
    $user = Yii::$app->request->get('user_id');

    if(!empty($user)){

      $result = Job::find()->select('job_type.id,job_type.job_type_name as type_name_job,COUNT(*) as total')
      ->innerJoin('job_type','job_type.id = job.job_type_id')
      ->where('DATE(job_date)
                  BETWEEN "'.$start.'" AND "'.$end.'"
                  AND user_id ="'.$user.'"')->groupBy('job_type_id')->asArray()->all();

      $user = User::findOne(Yii::$app->request->get('user_id'));

      $sub_title = $user->fullname;

    }else{

      $result = Job::find()->select('job_type.id,job_type.job_type_name as type_name_job,COUNT(*) as total')
      ->innerJoin('job_type','job_type.id = job.job_type_id')
      ->where('DATE(job_date)
                  BETWEEN "'.$start.'" AND "'.$end.'"')->groupBy('job_type_id')->asArray()->all();
      $sub_title = "";
    }

		$labels = array();

		$data2 = array();

		array_push($data2,Yii::t('app','performance_report'));

		foreach($result as $key => $val){

			$data2[] = $val['total'];

			$labels[] =  $val['type_name_job'];
		}

		$print = Yii::$app->request->get('print',false);

		if($print){

			$this->layout = "print";

			$render = "job_chart_print";

		}else{

			$render = "chart";
		}

        return $this->render($render, ['labels' => $labels,
			      'model'=>$result,
            'data' => $data2,
            'user_id'=>Yii::$app->request->get('user_id'),
            'start'=>Yii::$app->request->get('start'),
            'end'=>Yii::$app->request->get('end'),
      			'sub_title'=>$sub_title
        ]);
    }

	//print job chart report
	public function actionPrintChart() {

		$this->layout = "print";

        $query = JobType::find();

        $queryAll = $query->all();

        foreach ($queryAll as $data) {

            $count = Job::find()->where('DATE(job_date)
                BETWEEN "' . Yii::$app->request->get('start') . '" AND "' . Yii::$app->request->get('end') . '"
                AND user_id ="' . Yii::$app->request->get('user_id') . '"AND job_type_id = ' . $data['id'] . '')->count();

            $labels[] = $data['job_type_name'];

            $data2[] = $count;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => JobType::find(),
            'pagination' => false,
			       'sort'=>false,
        ]);

        return $this->render('job_chart_print', ['labels' => $labels,
            'data'=> $data2,
            'dataProvider' => $dataProvider,
            'user_id'=>Yii::$app->request->get('user_id'),
            'start'=>Yii::$app->request->get('start'),
            'end'=>Yii::$app->request->get('end'),
            'name'=>User::findOne(Yii::$app->request->get('user_id'))
        ]);
    }


	//export job data to excel
	public function actionJobExport() {

        $this->layout = "print";

        $user_id = Yii::$app->request->get('user_id');

        $query = Job::find()
		->where('DATE(job_date) BETWEEN "' . Yii::$app->request->get('start') . '" AND "' . Yii::$app->request->get('end') . '"');



		if(!empty($user_id)){

          $query->andWhere(['user_id'=>Yii::$app->request->get('user_id')]);

        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('job_export', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /*Device Report*/

    public function renderDeviceView($query , $search_items , $print = null){

      if($print == 'print' || $print == 'export'){

        $this->layout = "print";

        $render =  $print == 'print' ? "device_list_print" : "device_export";

        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false
        ]);

      }else{

        $render = "device_list";

        $dataProvider =  new ActiveDataProvider([
            'query' => $query,
        ]);
      }

      return $this->render($render,[
          'model'=> new Device(),
          'dataProvider' => $dataProvider,
          'search_items' => $search_items
      ]);
    }

    public function actionSearchTypeDepartment(){

      $device_type_id = Yii::$app->request->get('device_type_id',0);

      $department_id = Yii::$app->request->get('department_id',0);

      $device_status = Yii::$app->request->get('device_status','enable');

      $print = Yii::$app->request->get('print');

          if($device_type_id == 0 && $department_id == 0){
              //all device type
              $query = Device::find()->where(['device_status'=>$device_status])
              ->orderBy('department_id,device_type_id ASC');

          }else if($device_type_id == 0){
              $query = Device::find()
              ->where(['department_id'=>$department_id,'device_status'=>$device_status])
              ->orderBy('department_id,device_type_id ASC');

          }else if($department_id == 0){
              $query = Device::find()
              ->where(['device_type_id'=>$device_type_id,'device_status'=>$device_status])
              ->orderBy('department_id,device_type_id ASC');

          }else{
              $query = Device::find()
              ->where(['department_id'=>$department_id,'device_type_id'=>$device_type_id,'device_status'=>$device_status])
             ->orderBy('department_id,device_type_id ASC');
          }

          $search_items = array(
             'active' => 'type_department',
             'department_id' => $department_id,
             'device_type_id' => $device_type_id,
             'device_status' => $device_status
          );

          return $this->renderDeviceView($query,$search_items , $print);
    }


    public function actionSearchId(){

        $device_id = Yii::$app->request->get('device_id');

        $query = Device::find()->where(['device_id'=>$device_id]);

        $print = Yii::$app->request->get('print');

        $search_items = array(
           'active' => 'device_id',
           'device_id' => $device_id,
        );
        return $this->renderDeviceView($query,$search_items,$print);
      }

      public function actionSearchDeviceName(){

          $id = Yii::$app->request->get('device_name_id');

          $query = Device::find()->where(['id'=>$id]);

          $print = Yii::$app->request->get('print');

          $search_items = array(
             'active' => 'device_name',
             'device_name_id' => $id,
          );

          return $this->renderDeviceView($query,$search_items,$print);
      }


    public function actionSearchDeviceSn(){

        $serial_no = Yii::$app->request->get('serial_no');

        $query = Device::find()->where(['serial_no'=>$serial_no]);

        $print = Yii::$app->request->get('print');

        $search_items = array(
           'active' => 'serial_no',
           'serial_no' => $serial_no,
        );
        return $this->renderDeviceView($query,$search_items,$print);
    }


    public function actionSearchDeviceEmployee(){

        $employee_id = Yii::$app->request->get('employee_id');

        $query = Device::find()->where(['employee_id'=>$employee_id]);

        $print = Yii::$app->request->get('print');

        $search_items = array(
           'active' => 'employee_id',
           'employee_id' => $employee_id,
        );

        return $this->renderDeviceView($query,$search_items,$print);

      }


      public function actionSearchYearUse(){

          $year_use = Yii::$app->request->get('year_use');

          $query = Device::find()->where(['YEAR(date_use)'=>$year_use]);

          $print = Yii::$app->request->get('print');

          $search_items = array(
             'active' => 'year_use',
             'year_use' => $year_use,
          );

          return $this->renderDeviceView($query,$search_items,$print);

      }

      public function actionDeviceListHistoryPrint($id = null) {

          $this->layout = "print";

          $query = Job::find()->where(['device_id' => $id]);

          $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' => false,
              'sort'=>false,
          ]);

          if(Yii::$app->request->get('export') == 'export'){

            return $this->render('device_list_export', [
                'dataProvider' => $dataProvider,
            ]);

          }else{

            return $this->render('device_list_history_print', [
                'device' => Device::findOne($id),
                'dataProvider' => $dataProvider,
            ]);

          }


      }


    public function actionCostDepartment($month = null,$year = null){

	       $month = Yii::$app->request->get('month',date("m"));

	       $year = Yii::$app->request->get('year',date("Y"));

         $data = "";

          if(!empty($month) &&  !empty($year)){

              $sql = "SELECT employee.department_id,department_name,SUM(price) AS price FROM job
                 INNER JOIN employee ON employee.id = job.job_employee_id
                 INNER JOIN department ON department.id = employee.department_id
                 WHERE MONTH(job_date) = '".$month."' AND YEAR(job_date) = '".$year."'
                 GROUP BY department_name";

              $data = Yii::$app->db->createCommand($sql)->queryAll();
          }

          return $this->render('cost_department',[
              'data'=>$data,
              'month'=>$month,
              'year' =>$year
          ]);

    }


    public function actionDetailCost($month,$year,$department_id){

        $this->layout = "print";

        $query = Job::find()
                ->innerJoinWith('employee','employee.id = job.job_employee_id')
                ->where(['MONTH(job_date)'=>$month,'YEAR(job_date)'=>$year])
                ->andWhere(['employee.department_id'=>$department_id]);

        /*$query = "SELECT employee.department_id,department_name,SUM(price) AS price FROM job
           INNER JOIN employee ON employee.id = job.job_employee_id
           INNER JOIN department ON department.id = employee.department_id
           WHERE MONTH(job_date) = ".$month." AND YEAR(job_date) = ".$year."
           GROUP BY department_name";*/

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        //sum price
        $sum = $query->sum('price');

        return $this->render('cost_detail_department',[
            'dataProvider'=>$dataProvider,
            'sum'=>$sum
        ]);

    }


	public function actionCostExport($month,$year,$department_id){

        $this->layout = "print";

        $query = Job::find()
                ->innerJoinWith('device','device.id = job.device_id')
                ->where(['MONTH(job_date)'=>$month,'YEAR(job_date)'=>$year])
                ->andWhere(['device.department_id'=>$department_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('cost_detail_export',[
            'dataProvider'=>$dataProvider,
        ]);

    }


	public function actionChartType(){

        $start_date = Yii::$app->request->get('start_date',date("Y-m-01"));

        $end_date = Yii::$app->request->get('end_date',date('Y-m-t',strtotime('today')));

        $sql = "SELECT device_type.id,device_type as title, ( SELECT COUNT(*) FROM device
            INNER JOIN job ON device.id = job.device_id
            WHERE device.device_type_id = device_type.id
            AND DATE(job.job_date) BETWEEN '".$start_date."' AND '".$end_date."' )
            AS total
            FROM device_type";

        $chart_type = Yii::$app->db->createCommand($sql)->queryAll();

		$labels = array();

		$data2 = array();

		array_push($data2,Yii::t('app','maintenance_stat'));

        foreach($chart_type as $data){
			if($data['total'] > 0){
				$labels[] = $data['title'];
				$data2[] = $data['total'];
			}
        }

		$print = Yii::$app->request->get('print',false);

		$title = Yii::t('app','maintenance_device_type');

		$sub_title = Yii::t('app','device_type');

		if($print){

			$this->layout = "print";

			$render = "chart_print";

		}else{

			$render = "chart_type";
		}

        return $this->render($render,[
            'labels'=>$labels,
            'data'=>$data2,
            'model'=>$chart_type,
            'start_date' => $start_date,
            'end_date' => $end_date,
			      'print'=>$print,
			      'title'=>$title,
			      'sub_title'=>$sub_title,
        ]);

	}

    public function actionChartDepartment(){

        $start_date = Yii::$app->request->get('start_date',date("Y-m-01"));

        $end_date = Yii::$app->request->get('end_date',date('Y-m-t',strtotime('today')));

        $sql = "SELECT department.id,department_name AS title,
		        (SELECT COUNT(*) FROM job
            INNER JOIN employee ON job.job_employee_id = employee.id
            AND job.job_date BETWEEN '".$start_date."' AND '".$end_date."' WHERE employee.department_id = department.id ) as total
            FROM department";

        $model = Yii::$app->db->createCommand($sql)->queryAll();

		    $labels = array();

		    $data2 = array();

  		  array_push($data2,Yii::t('app','maintenance_stat'));
          foreach($model as $data){
      			if($data['total'] > 0){
      				$labels[] = $data['title'];
      				$data2[] = $data['total'];
      			}
        }

    		$print = Yii::$app->request->get('print',false);

    		$title = Yii::t('app','maintenance_department');

    		$sub_title = Yii::t('app','department_name');

    		if($print){

    			$this->layout = "print";

    			$render = "chart_print";

    		}else{

    			$render = "chart_department";
    		}

        return $this->render($render,[
            'labels'=>$labels,
            'data'=>$data2,
            'model'=>$model,
            'start_date' => $start_date,
            'end_date' => $end_date,
			'print'=>$print,
			'title'=>$title,
			'sub_title'=>$sub_title,
        ]);

    }

    public function actionChartJobType(){

		$start_date = Yii::$app->request->get('start_date',date("Y-m-01"));

		$end_date = Yii::$app->request->get('end_date',date("Y-m-d"));

		$result = Job::find()->select('job_type.id,job_type.job_type_name as title,COUNT(*) as total')
		->innerJoin('job_type','job_type.id = job.job_type_id')
		->where('DATE(job_date) BETWEEN "' .$start_date. '" AND "' . $end_date. '"')
		->groupBy('job_type_id')->asArray()->all();

		$labels = array();

		$data2 = array();

		array_push($data2,Yii::t('app','maintenance_stat'));

		foreach($result as $key => $val){

			$data2[] = $val['total'];

			$labels[] =  $val['title'];
		}

		$print = Yii::$app->request->get('print',false);

		$title = Yii::t('app','maintenance_job_type');
		$sub_title = Yii::t('app','job_type');

		if($print){

			$this->layout = "print";

			$render = "chart_print";

		}else{

			$render = "chart_job_type";
		}

      return $this->render($render , ['labels' => $labels,
			       'model'=>$result,
            'data' => $data2,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
			      'print'=>$print,
			      'title'=>$title,
			      'sub_title'=>$sub_title,
      ]);
    }

	public function actionPrintDetail(){

		$this->layout = "print";

		$start = Yii::$app->request->get('start');

		$end = Yii::$app->request->get('end');

		$job_type_id = Yii::$app->request->get('job_type_id');

		$type_id = Yii::$app->request->get('type_id');

		$department_id = Yii::$app->request->get('department_id');

		$user_id = Yii::$app->request->get('user_id');

		if(!empty($job_type_id)){

			$job_type = JobType::findOne($job_type_id);

			if(!empty($user_id)){

				$query = Job::find()->where('DATE(job_date) BETWEEN "' . $start . '" AND "' . $end . '"AND  job_type_id = ' . $job_type_id . ' AND user_id = '.$user_id.'');

				$user = User::findOne($user_id);

				$title = Yii::t('app','performance_report')." ".$user->fullname;

				$sub_title = Yii::t('app','job_type')." ".$job_type->job_type_name;

			}else{

				$query = Job::find()->where('DATE(job_date) BETWEEN "' . $start . '" AND "' . $end . '"AND  job_type_id = ' . $job_type_id . '');

				$title = Yii::t('app','maintenance_job_type');

				$sub_title = $job_type->job_type_name;
			}

		}else if(!empty($type_id)){

			$query = Job::find()
			->innerJoin('device','device.id = job.device_id')
			->where('device.device_type_id = ' . $type_id . ' AND DATE(job_date) BETWEEN "' . $start . '" AND "' . $end . '"');

			$title = Yii::t('app','maintenance_device_type');

			$device_type = DeviceType::findOne($type_id);

			$sub_title = $device_type->device_type;

		}else if(!empty($department_id)){

			$query = Job::find()
			->innerJoin('employee','employee.id = job.job_employee_id')
			->where('DATE(job_date) BETWEEN "' . $start . '" AND "' . $end . '"
			AND  employee.department_id = ' . $department_id . '');

			$title = Yii::t('app','maintenance_department');

			$department = Department::findOne($department_id);

			$sub_title = $department->department_name;
		}

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
			       'sort'=>false,
        ]);

        if(Yii::$app->request->get('export') == 'export'){

          return $this->render('print_detail_export', [
              'dataProvider' => $dataProvider,
          ]);

        }else{

          return $this->render('print_detail', [
              'dataProvider' => $dataProvider,
              'start'=>Yii::$app->request->get('start'),
              'end'=>Yii::$app->request->get('end'),
              'user_id' => $user_id,
              'job_type_id' => $job_type_id,
              'type_id' => $type_id,
              'department_id' => $department_id,
              'title'=>$title,
              'sub_title'=> !empty($sub_title) ? $sub_title : NULL,
          ]);

        }


	}


	public function actionDeviceTypeAll(){

		$result = Device::find()->select('device_type.device_type,COUNT(*)as total')
		->innerJoin('device_type','device_type.id = device.device_type_id ')
		->groupBy('device_type_id')->asArray()->all();

		$labels = array();

		$data2 = array();

		foreach($result as $key => $val){

			$data2[] = array( $val['device_type'],$val['total']);

			$labels[$val['device_type']] =  "pie";
		}

		$print = Yii::$app->request->get('print',false);

		if($print){

			$this->layout = "print";

			$render = "print_device_type_all";

		}else{

			$render = "device_type_all";
		}

      return $this->render($render, ['labels' => $labels,
			'model'=>$result,
            'data' => $data2,
        ]);
	}


  public function actionPrintDeviceDetail($id = null) {

      $this->layout = "print";

        if(!empty($id)){

          $software = ArrayHelper::map(SoftwareDetail::find()->all(), 'id', 'software_detail', 'softwareType.software_type');

          $software_name = array();

              if(!empty($software)){

                foreach ($software as $key => $val) {
                    if(!empty($val)){

                        foreach ($val as $vKey => $vVal) {

                            $result = Device::checkSoftware($id, $vKey);

                            if ($result) {

                                   $software_name[$key][] = array(
                                      'name' => $vVal,
                                      'sn' => Device::findSnbySoftware($id,$vKey)
                                   );
                            }
                        }
                    }
                }
            }

          return $this->render('print-device', [
              'model' => Device::findOne($id),
              'software' => $software_name
          ]);
       }
  }

  public function actionSoftwareReport(){

	   $software = Device::getSoftwareTotal();

		if(Yii::$app->request->get('print') == 'print'){

			$this->layout = "print";

			return $this->render('software_report_print', ['software' => $software]);

		}else{

			return $this->render('software_report', ['software' => $software]);

		}
  }

  public function actionSoftwareReportDetail($software_id = null){

     $this->layout = "print";

      $findDetail = Device::findSoftwareByDevice();

      $result = array();

      if(!empty($findDetail)){

        foreach($findDetail as $r){
            if($r['id'] == $software_id){

                $device = $this->getDeviceName($r['device_id']);

                  $result[] = array(
                      'software_name' => $this->getSoftwareName($r['id']),
                      'sn' => !empty($r['sn']) ? $r['sn'] : '',
                      'device_type' => !empty($device->deviceType->device_type) ? $device->deviceType->device_type: '',
                      'device_name' => !empty($device->device_name) ? $device->device_name : '',
                      'department_name' => !empty($device->department->department_name) ? $device->department->department_name : '',
                      'employee_name' => !empty($device->employee->user_fullname) ? $device->employee->user_fullname : '',
                  );
            }
          }

      }

      return $this->render('software-detail',['result' => $result]);

    }

  public function getDeviceName($device_id = null){

    if(!empty($device_id)){

       $device = Device::findOne($device_id);

       return !empty($device) ? $device : '';

    }

  }

  public function getSoftwareName($software_id = null){

       if(!empty($software_id)){
         $software_detail = SoftwareDetail::findOne($software_id);
         if(!empty($software_detail)){
           return $software_detail->software_detail;
         }
       }
  }

  public function actionEmployeeReport(){
	  $start_date = Yii::$app->request->get('start_date',date("Y-m-")."01");
	  $end_date =  Yii::$app->request->get('end_date',date("Y-m-t"));

	  $employee_id = Yii::$app->request->get('employee_id',0);

	  $print = Yii::$app->request->get('print');

	  	  	$query = Job::find()
			->where('job_employee_id = ' . (!empty($employee_id) ? $employee_id : 0) . ' AND DATE(job_date) BETWEEN "' . $start_date . '" AND "' . $end_date . '"')
			->orderBy('job_date ASC');

		  if($print == 'print' || $print == 'export'){

			  $this->layout = "print";

			  	$dataProvider = new ActiveDataProvider([
					'query' => $query,
					'pagination' => false,
					'sort'=>false,
				]);

				if($print == 'export'){

					  return $this->render('employee_report_export',[
						'dataProvider' => $dataProvider,
					  ]);
				}

		  }else{
				$dataProvider = new ActiveDataProvider([
					'query' => $query,
				]);
		  }

		  return $this->render('employee_report', [
				  'dataProvider' => $dataProvider,
				  'start_date'=> $start_date,
				  'end_date'=>$end_date,
				  'employee_id' => $employee_id,
				  'print' => $print,
		  ]);
  }

}
