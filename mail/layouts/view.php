<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Job;
/* @var $this yii\web\View */
/* @var $model common\models\Reserve */
?>

<div class="row">
	<div class="col-md-12">
	<p><b>ข้อมูลการแจ้งปัญหา</b></p>
        <?=
        DetailView::widget([
            'model' => $model,
            'template' => '<tr><th width="25%">{label}</th><td>{value}</td></tr>',
            'attributes' => [ 
				[
					'label' => 'วันที่แจ้ง',
					'format' => 'raw',
					'value' => Job::getDateTime($model->job_date),
				],
				'employee.user_fullname',
				'employee.user_position',
				'employee.department.department_name',
				'device.deviceType.device_type',
				'device.device_name',
				'job_detail',
            ],
        ])
        ?>
		
	</div>
</div>
<?php
$this->registerJs("

	//set for emply data
	$('.not-set').html('&nbsp;');

");
?>


