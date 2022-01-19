<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Job;

$this->title = Yii::t('app','job_print_title');
?>

		<h3 class="text-center" ><?= Html::encode($this->title) ?>
			<div class="pull-right" id="non-printable">
					<button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
					<button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>
<br>
			</div>

		</h3>

				<p class="text-right"> <?php echo $job_number = !empty($model->job_number) ? Yii::t('app','job_number')." ".$model->job_number : '';?></p>

				<h4><u><?=Yii::t('app','informer')?></u></h4>

				<p><?=Yii::t('app','job_request_date')?> : <?=Yii::$app->datethai->getDateTimeExport($model->job_date)?></p>
				<p><?=Yii::t('app','staff')?> :
						<?=!empty($model->employee->user_fullname) ? $model->employee->user_fullname : ''?></p>
				<p><?=Yii::t('app','position')?> : <?=!empty($model->employee->user_position) ? $model->employee->user_position : '' ?></p>
				<p><?=Yii::t('app','department_name')?> : <?=!empty($model->employee->department->department_name) ? $model->employee->department->department_name : ''?></p>


				<p><?=Yii::t('app','problem')?> : <?=$model->job_detail?></p>
				<hr>
				<h4><u><?=Yii::t('app','problem_info')?></u></h4>
				<p><?=Yii::t('app','job_type')?> : <?=!empty($model->jobType->job_type_name) ? $model->jobType->job_type_name : ' '?></p>
				<p><?=Yii::t('app','device_type')?> : <?=!empty($model->device->deviceType->device_type) ? $model->device->deviceType->device_type : '  '?></p>
				<p><?=Yii::t('app','device_id')?> : <?=!empty($model->device->device_id) ? $model->device->device_id : '  '?></p>
				<p><?=Yii::t('app','device_name')?> : <?=!empty($model->device->device_name) ? $model->device->device_name : '  '?></p>
				<p><?=Yii::t('app','operator')?> : <?=!empty($model->user->fullname) ? $model->user->fullname : ''?></p>
				<p><?=Yii::t('app','job_start_date')?> : <?=Yii::$app->datethai->getDateTimeExport($model->job_start_date)?></p>
				<p><?=Yii::t('app','job_success_date')?> : <?=Yii::$app->datethai->getDateTimeExport($model->job_success_date)?></p>
				<p><?=Yii::t('app','solution')?> : <?= $model->job_how_to_fix?></p>
				<p><?=Yii::t('app','price')?> : <?=number_format($model->price)?></p>
				<p><?=Yii::t('app','result')?> : <?= Job::getStatus($model->job_status)?></p>

        				<table id="print-table" style="font-size:16px;text-align:center;margin-top:90px;" width="100%">
        					<tr>

        							<td style="width:40%"><?=Yii::t('app','sign')?>...............................................</td>

        							<td style="width:20%"></td>

        							<td style="width:40%"><?=Yii::t('app','sign')?>...............................................</td>
        					</tr>
        					<tr>

        							<td style="width:40%;padding-top:15px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(...............................................)</td>

        							<td style="width:20%;padding-top:15px" ></td>

        							<td style="width:40%;padding-top:15px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(...............................................)</td>
        					</tr>
        					<tr>

        							<td style="width:40%"><?=Yii::t('app','staff')?></td>

        							<td style="width:20%"></td>

        							<td style="width:40%"><?=Yii::t('app','operator')?></td>
        					</tr>

        				</table>
