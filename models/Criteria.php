<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_type".
 *
 * @property integer $id
 * @property string  $criteria_detail
 * @property integer $criteria_scoll
 * @property integer $criteria_status
 *
 * @property Risk[] $risks
 */
class Criteria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'criteria_risk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['criteria_detail'], 'string', 'max' => 50],
            ['criteria_detail','required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'criteria_detail' => Yii::t('app','criteria'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRisk()
    {
        return $this->hasMany(Risk::className(), ['criteria_id' => 'id']);
    }
}
