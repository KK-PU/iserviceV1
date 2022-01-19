<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_type".
 *
 * @property integer $id
 * @property string $job_type_name
 *
 * @property Job[] $jobs
 */
class JobType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_type_name'], 'string', 'max' => 255],
            ['job_type_name','required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_type_name' => Yii::t('app','job_type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['job_type_id' => 'id']);
    }
}
