<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "job".
 *
 * @property integer $id
 * @property string $job_date
 * @property string $job_detail
 * @property string $job_start_date
 * @property string $job_success_date
 * @property string $job_how_to_fix
 * @property integer $price
 * @property string $job_status
 * @property integer $job_employee_id
 * @property integer $job_type_id
 * @property integer $criteria_id
 * @property integer $device_id
 * @property integer $user_id
 *
 * @property JobType $jobType
 * @property User2 $user
 * @property Employee $jobEmployee
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $upload_folder = 'uploads';

    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['job_date', 'job_start_date', 'job_success_date','job_number'], 'safe'],
            [['job_employee_id', 'job_type_id', 'device_id', 'user_id'], 'integer'],
            [['price'],'number'],
            [['job_date','job_employee_id', 'job_type_id','criteria_id','user_id'], 'required'],
            [['job_detail', 'job_how_to_fix'], 'string', 'max' => 1000],
            [['job_status','phone'], 'string', 'max' => 45],
            [['request_file','success_file'], 'file',
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
            'job_number' => Yii::t('app', 'job_number'),
            'job_date' => Yii::t('app', 'job_request_date'),
            'job_detail' => Yii::t('app', 'problem'),
            'job_start_date' => Yii::t('app', 'job_start_date'),
            'job_success_date' => Yii::t('app', 'job_success_date'),
            'job_how_to_fix' => Yii::t('app', 'solution'),
            'price' => Yii::t('app', 'price'),
            'job_status' => Yii::t('app', 'status'),
            'job_employee_id' => Yii::t('app', 'staff'),
            'job_type_id' => Yii::t('app', 'job_type'),
            'criteria_id' => Yii::t('app', 'criteria'),
            'device_id' => Yii::t('app','device_name'),
            'user_id' => Yii::t('app','operator'),
            'UserName'=> Yii::t('app','operator'),
            'file' => Yii::t('app','file'),
			      'detail' => Yii::t('app','detail'),
            'questionnaire' => Yii::t('app','questionnaire')
        ];
    }


	public function getUserName(){
		return $this->user->fullname;
	}

  public static function dateThai($date = ""){

      if(!empty($date) && $date != "0000-00-00"){

              $get_date = explode("-", $date);

              $month =  [Yii::t('app','jan'), Yii::t('app','feb'), Yii::t('app','mar'), Yii::t('app','apr'), Yii::t('app','may'), Yii::t('app','jun'),Yii::t('app','jul'),
               Yii::t('app','aug'),Yii::t('app','sep'), Yii::t('app','oct'), Yii::t('app','nov'), Yii::t('app','dec') ];

  			if($get_date["1"] != "00"){

  				$get_month = $get_date["1"]-1;

  				$get_year = $get_date["0"] + 543;

  				return  Yii::t('app','lang') == 'th' ? $get_date["2"]." ".$month[$get_month]." ".$get_year : $month[$get_month]." ".$get_date["2"].", ".$get_date["0"] ;
  			}

  		}
  }

	public static function getDateTime($get_date = null){

		if(!empty($get_date) && $get_date != "0000-00-00 00:00:00"){

			$date = explode(" ", $get_date);
			$date_t = Job::dateThai($date['0']);

		  return $date_t."  ".Yii::t('app','time')."  ".substr($date['1'],0,-3)."  น.";

		}

	}

    public static function dateShortThai($date = null){

		if(!empty($date) && $date != "0000-00-00"){

			$get_date = explode("-", $date);

      $month =  [ Yii::t('app','jan_short'), Yii::t('app','feb_short'), Yii::t('app','mar_short'), Yii::t('app','apr_short')
      , Yii::t('app','may_short'), Yii::t('app','jun_short'),Yii::t('app','jul_short'), Yii::t('app','aug_short'),
       Yii::t('app','sep_short'), Yii::t('app','oct_short'), Yii::t('app','nov_short'), Yii::t('app','dec_short') ];

			if($get_date["1"] != "00"){

				$get_month = $get_date["1"]-1;

				$get_year = $get_date["0"]+543;

        return  Yii::t('app','lang') == 'th' ? $get_date["2"]." ".$month[$get_month]." ".$get_year : $month[$get_month]." ".$get_date["2"].", ".substr($get_date["0"],2) ;

			}

		}else{
			return false;
		}
    }

	//show status name
	public static function getStatus($status = null){

    $status_name = "";

      if($status == "request"){

  		$status_name = "<span style='color:#000099'>".Yii::t('app','request_status')."</span>";

  		}else if($status == "wait"){

        $status_name = "<span style='color:#d99228'>".Yii::t('app','wait_status')."</span>";

      }else if($status == "claim"){

        $status_name = "<span style='color:#000099'>".Yii::t('app','claim_status')."</span>";

      }else if($status == "process"){

        $status_name = "<span style='color:#d99228'>".Yii::t('app','process_status')."</span>";

      }else if($status == "success"){

        $status_name = "<span style='color:#009900'>".Yii::t('app','success_status')."</span>";

      }else if($status == "cancel"){

        $status_name = "<span style='color:#cc3300'>".Yii::t('app','cancel_status')."</span>";

      }

		return $status_name;

	}



    public static function itemsAlias($key){

        $year_now = date("Y");

        $year_start = 2015;

        $year = array();

        for ($year_start; $year_now >= $year_start; $year_now--) {

            $year_show = Yii::t('app','lang') == 'th' ? $year_now + 543 : $year_now;

            $year[$year_now] = $year_show;

        }

        $items =[
            'month'=>[
                '01' => Yii::t('app','jan'),
                '02'=>Yii::t('app','feb'),
                '03'=>Yii::t('app','mar'),
                '04'=>Yii::t('app','apr'),
                '05'=>Yii::t('app','may'),
                '06'=>Yii::t('app','jun'),
                '07'=>Yii::t('app','jul'),
                '08'=>Yii::t('app','aug'),
                '09'=>Yii::t('app','sep'),
                '10'=>Yii::t('app','oct'),
                '11'=>Yii::t('app','nov'),
                '12'=>Yii::t('app','dec'),
            ],

        'year'=> $year
        ];

        return ArrayHelper::getValue($items, $key,[]);
    }

    public function getMonth(){
        return self::itemsAlias('month');
    }

	//count job status
	public static function CountStatus($get_status){

    $query = Job::find()->where(['job_status'=>$get_status]);

    if(Yii::$app->user->identity->role == 'support' && $get_status != 'request'){
      $query->andWhere(['user_id' => Yii::$app->user->identity->id]);
    }

		return $query->count();

	}



  public static function CountStatusByUser($get_status = null){

    return Job::find()->where(['job_status'=>$get_status,'job_employee_id' => Yii::$app->user->identity->id])->count();

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobType()
    {
        return $this->hasOne(JobType::className(), ['id' => 'job_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'job_employee_id']);
    }


    public function getDevice(){
        return $this->hasOne(Device::className(),['id'=>'device_id']);
    }
}
