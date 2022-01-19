<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app','work_report');
?>


	<h4 class="text-center"><?= Html::encode($this->title) ?> <?=$name?> </h4>

		<p><?="&nbsp; ".Yii::$app->datethai->getDate($start)." ".Yii::t('app','to')." ".Yii::$app->datethai->getDate($end);?> </p>

    <div class="pull-right margin-print" id="non-printable">

        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>

    </div>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
						'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
						'tableOptions'=>['class'=>'table'],
            'columns' => [
							[
	                'attribute' => 'job_date',
	                'options' => ['style' => 'width:10%'],
	        				'format' => 'html',
	                'value' => function($model) {
	                    $job_number = !empty($model->job_number) ? "<br><span class='text-primary'> No. ".$model->job_number."</span>" : '';
	                    return Yii::$app->datethai->getDateTime($model->job_date).$job_number;
	        				}
	            ],

	            [
	                'attribute'=>'device.device_name',
	                'options' => ['style' => 'width:10%'],
	            ],

	            [
	                'attribute' => 'job_employee_id',
	                'options' => ['style' => 'width:12%'],
	            				'format'=>'raw',
	            				'value'=>function($model){

	            					$name =  !empty($model->employee->user_fullname) ? $model->employee->user_fullname : " ";
							          $department =  !empty($model->employee->department->department_name) ? $model->employee->department->department_name : " ";

						                 return "<p>".$name."<br><small>".$department."</small></p>";
	            				}
	            ],
	            [
	                'attribute' => 'job_detail',
	                'options' => ['style' => 'width:15%'],
	                'format' => 'raw',
	                'value' => function($model){

	                    return $model->job_detail;
	                }
	            ],
	            [
	                'attribute' => 'job_how_to_fix',
	                'options' => ['style' => 'width:15%'],
	                'format' => 'raw',
	                'value' => function($model){

	                    return $model->job_how_to_fix;
	                }
	            ],
	            [
	                'attribute' => 'UserName',
	                'options' => ['style' => 'width:12%'],
	                'format' => 'raw',
	                'value' => function($model){
	                  $fullname = !empty($model->user->fullname) ? $model->user->fullname : '';
	                  $position = !empty($model->user->position) ? $model->user->position : '';
	                  return "$fullname<br><small>$position</small>";
	                }
	            ],
							[
									'attribute' => 'job_start_date',
									'options' => ['style' => 'width:10%'],
									'format' => 'html',
									'value' => function($model) {

											return Yii::$app->datethai->getDateTime($model->job_start_date);

									}
							],
							[
									'attribute' => 'job_success_date',
									'options' => ['style' => 'width:10%'],
									'format' => 'html',
									'value' => function($model) {

											return Yii::$app->datethai->getDateTime($model->job_success_date);

									}
							],
	            [
	                'attribute' => 'job_status',
	                'headerOptions' =>['class'=>'text-center'],
	                'contentOptions' =>['class' => 'text-center'],
	                'options' => ['style' => 'width:8%;'],
	        				'format'=>'html',
	                'value' => function($model) {
	        					  return Yii::$app->getdata->getStatus($model->job_status);
	        				},
	            ],
            ],
            'layout'=>'{items}'
    ]); ?>
