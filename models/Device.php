<?php

namespace app\models;

use Yii;
use app\models\DeviceType;
use app\models\SoftwareDetail;
use app\models\SoftwareType;
use yii\web\UploadedFile;
/**
 * This is the model class for table "device".
 *
 * @property integer $id
 * @property string $device_id
 * @property string $serial_no
 * @property string $device_brand
 * @property string $device_model
 * @property string $device_name
 * @property string $memory
 * @property string $cpu
 * @property string $harddisk
 * @property string $monitor
 * @property string $other_detail
 * @property string $device_ip
 * @property string $date_use
 * @property string $date_expire
 * @property double $device_price
 * @property string $device_docs
 * @property string $device_status
 * @property integer $device_type_id
 * @property integer $department_id
 *
 * @property Department $department
 * @property DeviceType $deviceType
 */
class Device extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

	public $file;


	//public $image;
	public $upload_folder = 'uploads';

    public static function tableName()
    {
        return 'device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_use', 'date_expire'], 'date', 'format' => 'yyyy-MM-dd'],
            [['device_price'], 'number'],
            [['device_id'], 'unique'],
            [['device_status', 'device_type_id', 'department_id'], 'required'],
            [['mouse','keyboard','ex_drive','hardware_other'],'string'],
            [['device_status','mac','software','software_detail','software_sn'], 'string'],
            [['device_type_id', 'department_id','employee_id'], 'integer'],
            [['device_id', 'serial_no', 'memory', 'device_docs'], 'safe'],
            [['device_brand', 'device_model', 'device_name', 'other_detail','vender','warranty'], 'safe'],
            [['cpu', 'harddisk', 'monitor', 'device_ip'], 'safe'],
			      [['file'],'file','extensions'=>'xls,xlsx'],
						[['image'], 'file',
                'maxFiles' => 4,
                'skipOnEmpty' => true,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_id' => Yii::t('app','device_id'),
            'serial_no' => Yii::t('app','serial_no'),
            'device_brand' => Yii::t('app','device_brand'),
            'device_model' => Yii::t('app','device_model'),
            'device_name' => Yii::t('app','device_name'),
            'device_type' => Yii::t('app','device_type'),
            'device_type_id' => Yii::t('app','device_type'),
            'department_id' => Yii::t('app','department_name'),
            'image'=> Yii::t('app','image'),
            'memory' => Yii::t('app','memory'),
            'cpu' => Yii::t('app','cpu'),
            'harddisk' => Yii::t('app','harddisk'),
            'monitor' => Yii::t('app','monitor'),
            'other_detail' => Yii::t('app','other_detail'),
            'device_ip' => Yii::t('app','device_ip'),
            'mac' => Yii::t('app','mac'),
            'date_use' => Yii::t('app','date_use'),
            'date_expire' => Yii::t('app','date_expire'),
            'device_price' => Yii::t('app','device_price'),
            'device_docs' => Yii::t('app','device_docs'),
            'mouse' => Yii::t('app','mouse'),
            'keyboard' => Yii::t('app','keyboard'),
            'device_status' => Yii::t('app','device_status'),
            'hardware_other' => Yii::t('app','hardware_other'),
      			'vender'=> Yii::t('app','vender'),
      			'warranty'=> Yii::t('app','warranty'),
      			'employee_id'=> Yii::t('app','employee_id'),
      			'software'=> Yii::t('app','software'),
      			'software_detail'=> Yii::t('app','software_detail'),
            'DeviceName' => Yii::t('app','device_name'),
      			'DeviceRepair'=> Yii::t('app','device_repair'),
      			'DeviceDetail'=> Yii::t('app','device_detail'),
            'DeviceDetailPrint' => Yii::t('app','device_info')
        ];
    }


	 public function upload($model,$attribute){
        $image = UploadedFile::getInstance($model,$attribute);
        $path = $this->getUploadPath();
        if($this->validate() && $image !== null){
            $fileName = md5($image->baseName.time()).'.'.$image->extension;
            if($image->saveAs($path.$fileName)){
                return $fileName;
            }
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }

    public function getUploadPath(){
        return Yii::getAlias('@webroot').'/'.$this->upload_folder.'/';
    }

    public function getUploadUrl(){
        return Yii::getAlias('@web').'/'.$this->upload_folder.'/';
    }

    public function getImageViewer(){
        return empty($this->image) ? Yii::getAlias('@web').'/'.$this->upload_folder.'/no_image.png' : $this->getUploadUrl().$this->image;
    }


    //virtual attirbute
    public function getDeviceName(){

		    $status = "";

    		if($this->device_status == 'disable'){

    			$status = '<span class="disable">  ('.Yii::t('app','deprecated').') </span>';
    		}

        return $this->device_name.$status;
    }


    public static function getStatus($device_status = null){

        if($device_status == 'disable'){

          return Yii::t('app','deprecated');

        }else if($device_status == 'enable'){

          return Yii::t('app','normal');
        }

    }

    public static function countStatus($status){
        if($status == 'repair'){

          /*return  Device::find()
          ->innerJoin('job','device.id = job.device_id')
          ->where('job_status <> "success"')->groupBy('device.id')->count();*/

		  return  Device::find()
          ->innerJoin('job','device.id = job.device_id')
		  ->where(['not in','job.job_status',['success','cancel']])->groupBy('device.id')->count();;

        }else{
            return Device::find()->where(['device_status'=>$status])->count();
        }

    }

	public static function checkOldDevice($day = null, $time = '')
	{
      if(!empty($day) && $day != "0000-00-00"){

    		$tims = time();

    		$seconds = strtotime($day);

    		if ( ! is_numeric($seconds))
    		{
    			$seconds = 1;
    		}

    		if ( ! is_numeric($time))
    		{
    			$time = time();
    		}

    		if ($time <= $seconds)
    		{
    			$seconds = 1;
    		}
    		else
    		{
    			$seconds = $time - $seconds;
    		}

    		$str = '';
    		$years = floor($seconds / 31536000);

    		if ($years > 0)
    		{
    			$str .= $years.'  '.Yii::t('app','year')."&nbsp;";
    		}

		  $seconds -= $years * 31536000;
		  $months = floor($seconds / 2628000);

  		if ($years > 0 OR $months > 0)
  		{
  			if ($months > 0)
  			{
  				$str .= $months."&nbsp;".Yii::t('app','month');
  			}

  			$seconds -= $months * 2628000;
  		}

  		$weeks = floor($seconds / 604800);

  		$days = floor($seconds / 86400);

  		if ($months > 0 OR $weeks > 0 OR $days > 0)
  		{
  			if ($days > 0)
  			{
  				$str .= '&nbsp;'.$days.'&nbsp;'.Yii::t('app','day');
  			}

  			$seconds -= $days * 86400;
  		}

  		$hours = floor($seconds / 3600);
      return $str;
  		//return substr(trim($str), 0, -1);
    }
	}

	public static function checkSoftware($id = null,$software_id = null){

		if(!empty($software_id)){

			$check = Device::findOne($id);

			if(!empty($check->software)){

				$soft = explode(",",$check->software);

				foreach($soft as $item){
					if($item == $software_id){
						return true;
					}
				}
			}
		}
		return false;
	}



	public static function repairCount($device_id = null){

		$count = Job::find()->where(['device_id'=>$device_id])->count();

		return $count;
	}

  public static function findSoftwareDetailName($software_id = null){

      $software = SoftwareDetail::find()
          ->select('software_detail')
          ->where(['id'=>$software_id])
          ->One();
      return $software->software_detail;

  }



  public static function findSoftwareByDevice(){

      $software = Device::find()
      ->select('id,software,software_sn')
      ->Where('software <> ""')
      ->All();

      $software_arr = array();

      if(!empty($software)){

         foreach($software as $software_device){

             $device_software = explode(",",$software_device->software);

              foreach($device_software as $s){

                  $software_arr[] = array(
                     'id' => $s,
                     'device_id' => $software_device->id,
										 'sn' => Device::findSn($s,$software_device['software_sn'])
                  );
              }
         }
      }

      return $software_arr;
  }


	public static function findSn($software_id = null ,$software_sn = null){

	  $result = json_decode($software_sn,true);
	  if(!empty($result)){
	       foreach($result as $r){

	         if(!empty($r[$software_id])){
	            return $r[$software_id];
	            break;
	         }
	       }
	    }
	}


 public static function getSoftwareTotal(){

      $softwareAll = SoftwareDetail::find()->All();

      $i = 0;  $arr = array(); $arr_device = array();
			$sn = 0;

      $software_type = SoftwareType::find()->All();

      $software_arr = Device::findSoftwareByDevice();

      if(!empty($software_type)){

          if(!empty($softwareAll)){

            foreach($software_type as $type){

                foreach($softwareAll as $s){

                  if($s->software_type_id == $type->id){

                       foreach($software_arr as $soft){

                           if($soft['id'] == $s->id){

															if(!empty($soft['sn'])){
																$sn++;
															}

                              //array_push($arr_device,$soft['device_id']);

                              $i++;
                           }
                       }
                       $arr[$type->software_type][] = array
                         (
                            'id' => $s->id,
                            'software_name' => $s->software_detail,
                            'total_install' => $i,//total software
														'total_sn' => $sn
                            //'device' => $arr_device
                         );

                       $arr_device = [];

                       $i = 0;
											 $sn = 0;
                  }
                }
            }/*end foreach*/
          }/*End if*/
      }/*End if*/

      return $arr;
 }


 public static function findSnbySoftware($device_id = null , $software_id = null){

        $device = Device::find()->select('software_sn')->where(['id'=>$device_id])->One();

          if(!empty($device->software_sn)){
              foreach(json_decode($device->software_sn) as $sn => $v){
                 if(!empty($v)){
                     foreach($v as $k => $s){
                         if($k == $software_id){
                           return $s;
                           break;
                         }
                     }
                  }
              }
          }
 }





    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeviceType()
    {
        return $this->hasOne(DeviceType::className(), ['id' => 'device_type_id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }
}
