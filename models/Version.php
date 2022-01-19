<?php

namespace app\models;

use Yii;


class Version extends \yii\db\ActiveRecord
{

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['version','update_date'], 'string'],

        ];
    }


}
