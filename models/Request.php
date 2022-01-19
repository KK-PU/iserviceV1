<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;
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
 * @property integer $device_id
 * @property integer $user_id
 */
class Request extends \yii\db\ActiveRecord
{

   public $upload_folder = 'uploads';
    /**
     * @inheritdoc
     */
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
            [['price', 'job_employee_id', 'job_type_id', 'device_id', 'user_id'], 'integer'],
            [['job_date','job_employee_id','job_detail'], 'required'],
            [['job_detail', 'job_how_to_fix'], 'string', 'max' => 1000],
            [['job_status','phone'], 'string', 'max' => 45],
            [['request_file'], 'file',
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
            'job_date' => Yii::t('app', 'job_request_date'),
            'job_detail' => Yii::t('app', 'problem'),
            'job_start_date' => Yii::t('app', 'job_start_date'),
            'job_success_date' => Yii::t('app', 'job_success_date'),
            'job_how_to_fix' => Yii::t('app', 'solution'),
            'price' => Yii::t('app', 'price'),
            'job_status' => Yii::t('app', 'status'),
            'job_employee_id' => Yii::t('app', 'staff'),
            'job_type_id' => Yii::t('app', 'job_type'),
            'device_id' => Yii::t('app','device_name'),
            'user_id' => Yii::t('app','operator'),
            'UserName'=> Yii::t('app','operator'),
            'request_file' => Yii::t('app','file'),
            'phone' => Yii::t('app','phone'),

        ];
    }



    public function upload($model, $attribute) {

       $image = UploadedFile::getInstance($model, $attribute);

       $path = $this->getUploadPath();

       if ($this->validate() && $image !== null) {

           $fileName = md5($image->baseName . time()) . '.' . $image->extension;

           if ($image->saveAs($path . $fileName)) {

               return $fileName;
           }
       }

       return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
   }

   public function getUploadPath() {
       return Yii::getAlias('@webroot') . '/' . $this->upload_folder . '/';
   }

   public function getUploadUrl() {
       return Yii::getAlias('@web') . '/' . $this->upload_folder . '/';
   }



	public function getJobType()
    {
        return $this->hasOne(JobType::className(), ['id' => 'job_type_id']);
    }

	public function getDevice(){
        return $this->hasOne(Device::className(),['id'=>'device_id']);
    }

	public function getUser()
    {
        return $this->hasOne(\dektrium\user\models\User::className(), ['id' => 'user_id']);
    }

	public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'job_employee_id']);
    }

}
