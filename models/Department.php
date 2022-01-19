<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string $department_name
 */
class Department extends \yii\db\ActiveRecord
{

  	public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['department_name'], 'string', 'max' => 255],

            ['department_name','unique'],
            ['department_name','required'],
            [['file'],'file','extensions'=>'xls,xlsx'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'department_name' => Yii::t('app', 'department_name'),
        ];
    }
}
