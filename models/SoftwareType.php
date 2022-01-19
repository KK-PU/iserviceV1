<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "software_type".
 *
 * @property integer $id
 * @property string $software_type
 */
class SoftwareType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'software_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['software_type'], 'required'],
            [['software_type'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'software_type' => Yii::t('app','software_type'),
        ];
    }
}
