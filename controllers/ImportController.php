<?php
namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\models\Employee;
use app\models\DeviceType;
use app\models\Department;
use app\models\Device;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\AccessRule;


class ImportController  extends Controller {

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

    public function actionIndex(){
		    return $this->render('index');
    }


    public function actionExportDeviceType(){
        $query = DeviceType::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('export_type', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportDepartment(){
        $query = Department::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('export_department', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionExportEmployee(){
        $query = Employee::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('export_employee', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionExportDevice(){
        $query = Device::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        return $this->render('export_device', [
            'dataProvider' => $dataProvider,
        ]);
    }

	//upload file excel
	public function actionDeviceType(){

	    $model = new DeviceType();

      $message = "Please select File device_type.xlsx";

        if ($model->load(Yii::$app->request->post())) {

			       $file = UploadedFile::getInstance($model, 'file');

        			if(empty($file) || $file != 'device_type.xlsx'){

                return $this->render('import_type', ['model' => $model,'message' => $message]);

        			}else{

                $model->file = $file;

                 $fileName = rand(0, 999);

                 //save file to folder web/upload
                 $model->file->saveAs('file/' . $fileName . '.' . $model->file->extension);

                 //import excel file to product table
                 $result = $this->actionImportType('file/' . $fileName . '.' . $model->file->extension);

                 return $this->render('view_device_type',[
                   'result' => $result['result'],
                   'count_error' => $result['count_error'],
                   'count_success' => (count($result['result']) - $result['count_error']),
                 ]);
              }

        }else{

			       return $this->render('import_type', ['model' => $model ,'message' => $message]);
		   }
	}

	//import data to database
    public function actionImportType($inputFile = null) {

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);

        } catch (yii\base\Exception $e) {
            die('Error');
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $error = array();
        $count_error = 0;

        for ($row = 1; $row <= $highestRow; $row++) {

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            if ($row == 1) {
                continue;
            }

            $device_type = DeviceType::find()->where(['id' => $rowData['0']['0']])->One();

            if(!empty($device_type)){

              $deviceType = $device_type;

            }else{

                $deviceType = new DeviceType();
            }
                $deviceType->device_type = trim($rowData['0']['1']);
                $deviceType->save();

                if($deviceType->getErrors()){
                    $count_error++;
                    $error[] = $deviceType->getErrors();
                }


            $result[] = array(
              'device_type' => $rowData['0']['1'],
              'error' =>  $error,
            );

            $error = array();

          }

          return  array('result' => $result , 'count_error' => $count_error);
      }




	//upload file excel
	public function actionDepartment(){

	    $model = new Department();

      $message = "Please select File department.xlsx";

        if ($model->load(Yii::$app->request->post())) {

			       $file = UploadedFile::getInstance($model, 'file');

      			if(empty($file) || $file != 'department.xlsx'){

      				return $this->render('import_department', ['model' => $model , 'message' => $message]);
      			}

            $model->file = $file;

            $fileName = rand(0, 999);

            //save file to folder web/upload
            $model->file->saveAs('file/' . $fileName . '.' . $model->file->extension);

            //import excel file to product table
            $result = $this->actionImportDepartment('file/' . $fileName . '.' . $model->file->extension);

            return $this->render('view_department',[
              'result' => $result['result'],
              'count_error' => $result['count_error'],
              'count_success' => (count($result['result']) - $result['count_error']),
            ]);

        }else{

			  return $this->render('import_department', ['model' => $model , 'message' => $message]);
		}

	}

	//import data to database
  public function actionImportDepartment($inputFile) {

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);

        } catch (yii\base\Exception $e) {
            die('Error');
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $error = array();
        $count_error = 0;

        for ($row = 1; $row <= $highestRow; $row++) {

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                if ($row == 1) {
                    continue;
                }

                $department_name = Department::findOne($rowData['0']['0']);

                if(!empty($department_name)){

                  $department = $department_name;

                }else{

                  $department = new Department();
                }

                $department->department_name = trim($rowData['0']['1']);

                $department->save();

          			if($department->getErrors()){
                    $count_error++;
                    $error[] = $department->getErrors();
          			}


            $result[] = array(
              'id' => $rowData['0']['0'],
              'department' => $rowData['0']['1'],
              'error' =>  $error,
            );

            $error = array();
        }

        return  array('result' => $result , 'count_error' => $count_error);
  }


	//upload file excel
	public function actionEmployee(){

	    $model = new Employee();

      $message = "Please select File employee.xlsx";

        if ($model->load(Yii::$app->request->post())) {

			       $file = UploadedFile::getInstance($model, 'file');

        			if(empty($file) || $file != 'employee.xlsx'){

        				return $this->render('import_employee', ['model' => $model,'message' => $message]);

        			}

              $model->file = $file;

              $fileName = rand(0, 999);

            //save file to folder web/upload
              $model->file->saveAs('file/' . $fileName . '.' . $model->file->extension);

              //import excel file to product table
              $result =  $this->actionImportEmployee('file/' . $fileName . '.' . $model->file->extension);

              return $this->render('view_employee',[
                'result'=> $result['result'],
                'count_error' => $result['count_error'],
                'count_success' => (count($result['result']) - $result['count_error']),
              ]);

          }else{

  			       return $this->render('import_employee', ['model' => $model,'message' => $message]);
  		    }
	}


	public function actionImportEmployee($inputFile = null) {

        try {

            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);

          } catch (yii\base\Exception $e) {
              die('Error');
          }

          $sheet = $objPHPExcel->getSheet(0);
          $highestRow = $sheet->getHighestRow();
          $highestColumn = $sheet->getHighestColumn();

          $result = array();

          $error = array();

          $count_error = 0;

        for ($row = 1; $row <= $highestRow; $row++) {

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            if ($row == 1) {
                continue;
            }

            $update = Employee::find()->where(['id'=>$rowData['0']['0']])->One();

            if(!empty($update->id)){

              $employee = $update;

			  if(!empty($rowData['0']['6'])){

				  $employee->username = trim($rowData['0']['6']);

				  if(empty($update->password_hash)){
					  $employee->password_hash = '$2y$13$La/jpAAiH21XbHeB0Im8AOklBA90rAmWYHVOiWdRXDjxjnaMrseJu';
					  //$employee->password_hash = Yii::$app->security->generatePasswordHash($rowData['0']['7']);
				  }
			  }

            }else{

              $employee = new Employee();

			    if(!empty($rowData['0']['6'])){

				  $employee->username = trim($rowData['0']['6']);

				  $employee->password_hash = '$2y$13$La/jpAAiH21XbHeB0Im8AOklBA90rAmWYHVOiWdRXDjxjnaMrseJu';

				}

            }

              $employee->user_fullname = trim($rowData['0']['1']);
              $employee->user_position = trim($rowData['0']['2']);

			  if(!empty($rowData['0']['3'])){
				 $employee->user_email = trim($rowData['0']['3']);
			  }

              $employee->user_phone = trim($rowData['0']['4']);

  			  $department = Department::find()->where(['department_name'=>trim($rowData['0']['5'])])->One();

			  $employee->department_id = !empty($department->id) ? $department->id : NULL;



              $employee->role = 'user';
              $employee->save();

              if($employee->getErrors()){

                  $count_error++;
                  $error[] = $employee->getErrors();

              }

            $result[] = array(
              'fullname' => $rowData['0']['1'],
              'email' => $rowData['0']['2'],
              'phone' => $rowData['0']['3'],
              'position' => $rowData['0']['4'],
              'department' => $rowData['0']['5'],
              'username' => $rowData['0']['6'],
              'password' =>  Yii::t('app','default_password'),
              'error' =>  $error,
            );


          $error = array();
      }

        return  array('result' => $result , 'count_error' => $count_error);
    }


	//upload file excel
	public function actionDevice(){

	    $model = new Device();

      $message = "Please select File device.xlsx";

        if ($model->load(Yii::$app->request->post())) {

      			$file = UploadedFile::getInstance($model, 'file');

      			if(empty($file) || $file != "device.xlsx"){

      				return $this->render('import_device', ['model' => $model,'message' => $message]);

      			}

            $model->file = $file;

            $fileName = rand(0, 999);

            //save file to folder web/upload
            $model->file->saveAs('file/device_' . $fileName . '.' . $model->file->extension);

            //import excel file to product table
            $result = $this->actionImportDevice('file/device_' . $fileName . '.' . $model->file->extension);

			      return $this->render('view_device',[
                'result'=> $result['result'],
                'count_error' => $result['count_error'],
                'count_success' => (count($result['result']) - $result['count_error'])
              ]);

        }else{

          return $this->render('import_device', ['model' => $model,'message' => $message]);

		}
	}

	public function actionImportDevice($inputFile) {

        try {

            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);

        } catch (yii\base\Exception $e) {
            die('Error');
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

		    $error = array();
        $result = array();
        $count_error = 0;

        for ($row = 1; $row <= $highestRow; $row++) {

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            if ($row == 1) {
                continue;
            }

              $update_device = Device::findOne($rowData['0']['0']);

          		if(!empty($update_device)){

                $device = $update_device;

              }else{

                  $device = new Device();
              }

              $device->device_id = trim($rowData['0']['1']);
        			$device->serial_no = trim($rowData['0']['2']);
        			$device->device_brand = trim($rowData['0']['3']);
        			$device->device_model = trim($rowData['0']['4']);
        			$device->device_name = trim($rowData['0']['5']);
        			$device->memory = trim($rowData['0']['6']);
        			$device->cpu = trim($rowData['0']['7']);
        			$device->harddisk = trim($rowData['0']['8']);
        			$device->monitor = trim($rowData['0']['9']);
        			$device->mouse = trim($rowData['0']['10']);
        			$device->keyboard = trim($rowData['0']['11']);
        			$device->ex_drive = trim($rowData['0']['12']);
        			$device->hardware_other = trim($rowData['0']['13']);
        			$device->device_ip = trim($rowData['0']['14']);
              $device->mac = trim($rowData['0']['15']);

              $device->date_use = trim($rowData['0']['16']);
              $device->date_expire  = trim($rowData['0']['17']);

              if($rowData['0']['21'] == 'enable' || $rowData['0']['21'] == 'disable'){
                    $status = trim($rowData['0']['21']);
              }else{
                    $status = 'enable';
              }

              $device->device_price = trim($rowData['0']['18']);
              $device->vender = trim($rowData['0']['19']);
              $device->warranty = trim($rowData['0']['20']);
              $device->device_status = trim($status);
  	          $device->other_detail = trim($rowData['0']['22']);

        			$device_type = DeviceType::find()->where(['device_type'=>trim($rowData['0']['23'])])->One();

        			$department = Department::find()->where(['department_name'=>trim($rowData['0']['24'])])->One();

        			$employee_id = Employee::find()->where(['user_fullname'=>trim($rowData['0']['25'])])->One();

        			$device->employee_id = !empty($employee_id['id']) ? $employee_id['id'] : NULL;

        			$device->department_id = !empty($department['id']) ? $department['id'] : NULL;

        			$device->device_type_id = !empty($device_type['id']) ? $device_type['id'] : NULL;

        			$device->save();

        				if($device->getErrors()){
                    $count_error++;
                    $error = $device->getErrors();
        				}

                $result[] = array(
                  'device_id' => $rowData['0']['1'],
            			'serial_no' => $rowData['0']['2'],
            			'device_brand' =>$rowData['0']['3'],
            			'device_model' => $rowData['0']['4'],
            			'device_name' => $rowData['0']['5'],
            			'memory' => $rowData['0']['6'],
            			'cpu' => $rowData['0']['7'],
            			'harddisk' => $rowData['0']['8'],
            			'monitor' => $rowData['0']['9'],
            			'mouse' => $rowData['0']['10'],
            			'keyboard' => $rowData['0']['11'],
            			'ex_drive' => $rowData['0']['12'],
            			'hardware_other' => $rowData['0']['13'],
            			'device_ip' => $rowData['0']['14'],
                  'mac' => $rowData['0']['15'],
                  /*'date_use' => $date_use,
                  'date_expire' => $date_expire,*/
                  'date_use' => $rowData['0']['16'],
                  'date_expire' => $rowData['0']['17'],

                  'device_price' => $rowData['0']['18'],
                  'vender' =>$rowData['0']['19'],
                  'warranty' => $rowData['0']['20'],
                  'device_status' => $status,
      	          'other_detail' => $rowData['0']['22'],
                  'device_type' => !empty($device_type['id']) ? $rowData['0']['23'] : '<small class="text-danger">ไม่พบข้อมูล</small>',
                  'depatment_name' => !empty($department['id']) ? $rowData['0']['24'] : '<small class="text-danger">ไม่พบข้อมูล</small>',
                  'employee_id' => !empty($employee_id['id']) ? $rowData['0']['25'] : '<small class="text-danger">ไม่พบข้อมูล</small>',
                  'error' => $error
                );

                $error = array();
  			   }


          return  array('result' => $result , 'count_error' => $count_error);
    }

	public function actionError($error){
		return $this->render('error',['name'=>'Error','message'=>$error]);
	}


}
