<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "software_detail".
 *
 * @property integer $id
 * @property integer $software_type_id
 * @property string $software_detail
 */
class SoftwareDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'software_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['software_type_id', 'software_detail'], 'required'],
            [['software_type_id'], 'integer'],
            [['software_detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'software_type_id' => Yii::t('app','software_type'),
            'software_detail' => Yii::t('app','software_name'),
        ];
    }

	public function getSoftwareType()
    {
        return $this->hasOne(SoftwareType::className(), ['id' => 'software_type_id']);
    }
}
