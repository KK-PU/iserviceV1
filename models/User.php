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
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

		public $oldPassword;
		public $newPassword;
		public $confirmPassword;
	  public $password;

	  const ROLE_SUPPORT = 'support';
    const ROLE_ADMIN = 'admin';

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

    public static function tableName()
    {
        return 'user';
    }


		public $strRoles = [
				self::ROLE_SUPPORT => 'Support',
				self::ROLE_ADMIN => 'Admin',
		];


		public function getRoles($role = null){
				if($role === null){
						return Yii::t('app',$this->strRoles[$this->role]);
				}
				return Yii::t('app',$this->strRoles[$role]);
		}

    public function rules()
    {
        return [

            ['username', 'trim'],

            ['username', 'required'],

            ['password', 'required','on'=>'create'],

            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],

						['username', 'unique', 'targetClass' => '\app\models\Employee', 'message' => 'This username has already been taken Employee.'],

						['username', 'string', 'min' => 2, 'max' => 255],

						[['fullname','password'], 'required','on' => 'create'],

            [['password','password_hash'], 'string', 'min' => 4],

						['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            [['fullname'], 'string', 'max' => 45],

            [['position'], 'string', 'max' => 100],

						['role', 'required'],

						['role','default','value' => self::ROLE_SUPPORT],

						['role','in','range' => [self::ROLE_ADMIN,self::ROLE_SUPPORT]],

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
            'fullname' => Yii::t('app','user_fullname'),
            'position' => Yii::t('app','position'),
            'email' => Yii::t('app','email'),
						'role' => Yii::t('app','role')
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

					  $user = User::findOne(Yii::$app->user->identity->id);

						$user->fullname = $this->fullname;

						$user->username = $this->username;

						$user->position = $this->position;

						$user->email = $this->email;

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

		public function setPassword($password)
		{
				$this->password_hash = Yii::$app->security->generatePasswordHash($password);
		}
    		public function getId()
    	 {
    			 return $this->getPrimaryKey();
    	 }

	     public function getAuthKey()
	     {
	         return $this->auth_key;
	     }


	     public function validateAuthKey($authKey)
	     {
	         return $this->getAuthKey() === $authKey;
	     }


			 public function validatePassword($password)
	     {
	         return Yii::$app->security->validatePassword($password, $this->password_hash);
	     }

       /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }



}
