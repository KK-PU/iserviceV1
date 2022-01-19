<?php
use yii\helpers\Html;
?>

<?php
	echo Html::a('<i class="glyphicon glyphicon-th-list"></i> '.Yii::t('app','work_report'),[
			'job-report',
				'user_id'=>$user_id,
				'start'=>$start,
				'end'=>$end,
	],['class'=>'btn btn-default btn-sm']);
?>

<?php

	echo  Html::a('<i class="glyphicon glyphicon-stats"></i> '.Yii::t('app','performance_report'),[
					'chart-report',
						'user_id'=>$user_id,
						'start'=>$start,
						'end'=>$end,
	],['class'=>'btn btn-default btn-sm']);

?>
