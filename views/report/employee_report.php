<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;

$this->title = Yii::t('app','maintenance_stat');

$gridColumns = [
	[
			'attribute'=>'job_date',
			'options' => ['style' => 'width:10%'],
			'format' => 'html',
			'value' => function($model) {

					return Yii::$app->datethai->getDateTimeExport($model->job_date);
			}
	],
	[
			'attribute'=>'employee.user_fullname',
			'options' => ['style' => 'width:15%'],
	],

	[
					'attribute'=>'job_detail',
					'options' => ['style' => 'width:25%'],
	],
	[
					'attribute'=>'job_how_to_fix',
					'options' => ['style' => 'width:20%'],
	],
	 [
					'attribute'=>'UserName',
					'options' => ['style' => 'width:15%'],
					'value'=>'user.fullname',
	 ],
	 [
	 'attribute'=>'job_start_date',
	 'options' => ['style' => 'width:10%'],
	 'format' => 'html',
	 'value' => function($model) {
		 return Yii::$app->datethai->getDateTimeExport($model->job_start_date);
	 }
	 ],
	 [
	 'attribute'=>'job_success_date',
	 'options' => ['style' => 'width:10%'],
	 'format' => 'html',
	 'value' => function($model) {
		 return Yii::$app->datethai->getDateTimeExport($model->job_success_date);
	 }
	 ],
[
					'attribute'=>'price',
					'options' => ['style' => 'width:5%'],
	 ],
	[
					'attribute'=>'job_status',
					'format'=>'html',
					'options' => ['style' => 'width:10%'],
					'value'=>function($model){
							return Yii::$app->getdata->getStatus($model->job_status);
					},
	],

];
?>

	<?php if($print != 'print'){?>

		<h4><i class="glyphicon glyphicon-file"></i>  <?= Html::encode($this->title) ?></h4>

		<?=$this->render('_menu',['active'=>'chart_type']);?>
		<br>
		<h4 class="text-center"><?=Yii::t('app','employee_report')?> <?="&nbsp;".Yii::$app->datethai->getDate($start_date)." ".Yii::t('app','to')."  ".Yii::$app->datethai->getDate($end_date);?>  </h4>

		<?=$this->render('_search_employee_report',['start_date'=>$start_date,'end_date'=>$end_date,'employee_id'=>$employee_id])?>

	<?php }else{ ?>

		<h4 class="text-center"><?=Yii::t('app','employee_report')?> <?="&nbsp;".Yii::$app->datethai->getDate($start_date)." ".Yii::t('app','to')."  ".Yii::$app->datethai->getDate($end_date);?>  </h4>

		<div class="pull-right margin-print" id="non-printable">

			<?php
			echo ExportMenu::widget([
					'dataProvider' => $dataProvider,
					'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
					'columns' => $gridColumns,
					'clearBuffers' => true,
					'target' => '_self',
					'columnSelectorOptions' => ['class' => 'btn btn-default btn-sm'],
					'dropdownOptions' => ['class' => 'btn btn-default btn-sm'],
					'showConfirmAlert' => false,
					'exportConfig' => [
							ExportMenu::FORMAT_CSV => false,
							ExportMenu::FORMAT_HTML => false,
							ExportMenu::FORMAT_TEXT => false,
							ExportMenu::FORMAT_PDF => false,
							ExportMenu::FORMAT_EXCEL => false
					]
			]);
			?>

			<button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
			<button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>
		</div>

	<?php }?>
	<?= GridView::widget([
					'dataProvider' => $dataProvider,
					'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
					'tableOptions'=>['class'=>'table report-table'],
					'columns' =>
					[
									[
											'attribute' => 'job_date',
											'options' => ['style' => 'width:8%'],
											'format' => 'html',
											'value' => function($model) {
													$job_number = !empty($model->job_number) ? "<br>No. ".$model->job_number : '';
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
	]); ?>
