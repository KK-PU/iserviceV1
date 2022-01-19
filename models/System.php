<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system".
 *
 * @property integer $id
 * @property string $line_token
 * @property integer $login_required
 */
class System extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['line_token'], 'required'],
            [['login_required'], 'integer'],
            [['line_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'line_token' => Yii::t('app', 'Line Token'),
            'login_required' => Yii::t('app', 'Login Required'),
        ];
    }
}
