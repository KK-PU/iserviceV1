<?php
use app\models\Job;
use app\components\ExcelGrid;

ExcelGrid::widget([
    'dataProvider' => $dataProvider,
		'extension'=>'xlsx',
		'filename'=> Yii::t('app','device_maintenance'),
		'properties' =>[
		'title' 	=> Yii::t('app','device_maintenance'),
		],
]);
?>
