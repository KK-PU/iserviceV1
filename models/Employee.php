<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "employee".
 *
 * @property integer $id
 * @property string $user_fullname
 * @property string $user_position
 * @property integer $department_id
 *
 * @property Department $department
 * @property Job[] $jobs
 */


//class Employee extends \yii\db\ActiveRecord implements IdentityInterface
class Employee extends User
{

	 public $file;

	 public $oldPassword;
	 public $newPassword;
	 public $confirmPassword;
	 public $password;

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['username', 'trim'],

            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],

						['username', 'unique', 'targetClass' => '\app\models\Employee', 'message' => 'This username has already been taken Employee.'],

					  ['username', 'string', 'min' => 2, 'max' => 255],

            [['password','password_hash'], 'string', 'min' => 4],

						['user_email','email'],

            [['department_id','user_fullname'], 'required'],

            [['department_id'], 'integer'],
						['user_phone','safe'],

            [['user_fullname'], 'unique'],

						['role','default','value' => 'user'],

            [['user_position','role'], 'string', 'max' => 100],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
			 			[['file'],'file','extensions'=>'xls,xlsx'],


						[['oldPassword','confirmPassword','newPassword'],'required','on' => 'update_profile'],

						['oldPassword', 'validateOldPassword'],

						['confirmPassword', 'compare', 'compareAttribute' => 'newPassword','message'=>'Passwords ไม่ตรงกับรหัสผ่านใหม่ กรุณาลองอีกครั้ง'],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_fullname' => Yii::t('app','user_fullname'),
            'user_position' => Yii::t('app','position'),
            'department_id' => Yii::t('app','department_name'),
						'user_email' =>  Yii::t('app','email'),
						'user_phone' => Yii::t('app','phone'),
        ];
    }



				public function validateOldPassword($attribute, $params){

		        if (!$this->hasErrors()) {

		            if (!$this->validatePassword($this->oldPassword)) {

		                $this->addError($attribute, 'รหัสผ่านปัจจุบันไม่ถูกต้อง กรุณาตรวจสอบ');
		            }
		        }
		    }


				public function editUserProfile(){

						if ($this->validate()) {

							  $user = Employee::findOne(Yii::$app->user->identity->id);

								$user->user_fullname = $this->user_fullname;

								$user->username = $this->username;

								$user->user_position = $this->user_position;
								
								$user->user_phone = $this->user_phone;

								$user->user_email = $this->user_email;

								$user->password_hash = Yii::$app->security->generatePasswordHash($this->confirmPassword);

								$user->save();

								return true;
						}

						return false;
				}

		public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

		public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

		public static function findIdentityByAccessToken($token, $type = null)
    {
        /*throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');*/
        return static::findOne(['auth_key' => $token]);
    }


	 public function getId()
	 {
			 return $this->getPrimaryKey();
	 }

	 public function getAuthKey()
   {
       return $this->auth_key;
   }

	 public function generateAuthKey()
		{
				$this->auth_key = Yii::$app->security->generateRandomString();
		}


	     /**
	      * @inheritdoc
	      */
	     public function validateAuthKey($authKey)
	     {
	         return $this->getAuthKey() === $authKey;
	     }


			 public function validatePassword($password)
	     {
	         return Yii::$app->security->validatePassword($password, $this->password_hash);
	     }

			public function setPassword($password)
  		{
  				$this->password_hash = Yii::$app->security->generatePasswordHash($password);
  		}

      public static function getEmployeeName($employee_id = null){

        if(!empty($employee_id)){

                  $employee = Employee::findIdentity($employee_id);

									if(!empty($employee)){
										  return $employee->user_fullname;
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
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['job_employee_id' => 'id']);
    }
}
