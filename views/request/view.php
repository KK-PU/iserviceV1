<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Job;
/* @var $this yii\web\View */
/* @var $model common\models\Reserve */

?>
<div class="row">
	<div class="col-md-12">
		<p><b><?=Yii::t('app','problem_info')?></b></p>
	        <?=
	        DetailView::widget([
	            'model' => $model,
	            'template' => '<tr><th width="15%">{label}</th><td>{value}</td></tr>',
	            'attributes' => [
								[
									'label' => Yii::t('app','job_request_date'),
									'format' => 'raw',
									'value' => Job::getDateTime($model->job_date),
								],
								'employee.user_fullname',
								'employee.user_position',
								'employee.department.department_name',
								'job_detail',


	            ],
	        ])
	        ?>

	    <p><b><?=Yii::t('app','solution')?></b></p>
	            <?=
	        DetailView::widget([
	            'model' => $model,
	            'template' => '<tr><th width="15%">{label}</th><td>{value}</td></tr>',
	            'attributes' => [

							'device.deviceType.device_type',
							'device.device_id',
							'device.device_name',
							'jobType.job_type_name',
							[
								'label' => Yii::t('app','operator'),
								'format' => 'raw',
								'value' => !empty($model->user->fullname) ? $model->user->fullname : ''
							],
							[
								'label' => Yii::t('app','job_start_date'),
								'format' => 'raw',
								'value' => Job::getDateTime($model->job_start_date),
							],
							[
								'label' => Yii::t('app','job_success_date'),
								'format' => 'raw',
								'value' => Job::getDateTime($model->job_success_date),
							],
								'job_how_to_fix',
							[
							 			'label' => Yii::t('app','status'),
			              'format' => 'raw',
							 			'value'=> Job::getStatus($model->job_status),
							],


	            ],
	        ])
	        ?>

        <?=Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),['job/print','id'=>$model->id],['class'=>'btn btn-primary','target'=>'_blank'])?>
				<?=Html::a('<i class="glyphicon glyphicon-off"></i> '.Yii::t('app','close'),null,['class'=>'btn btn-default pull-right','data-dismiss'=>'modal']);?>
	</div>
</div>
<?php
$this->registerJs("

	//set for emply data
	$('.not-set').text('');

");
?>
