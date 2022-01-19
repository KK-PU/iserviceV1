<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "device_type".
 *
 * @property integer $id
 * @property string $device_type
 *
 * @property Device[] $devices
 */
class DeviceType extends \yii\db\ActiveRecord
{

	public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_type'], 'string', 'max' => 45],
						['device_type','required'],
						['device_type','unique'],
						[['file'],'file','extensions'=>'xls,xlsx'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_type' => Yii::t('app','device_type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::className(), ['device_type_id' => 'id']);
    }
}
