<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Department;
use app\models\DeviceType;
use app\models\Device;
use app\models\Job;
use app\models\Employee;
use yii\grid\GridView;

use kartik\export\ExportMenu;

$deviceModel = Device::find()->All();


$department = ArrayHelper::map(Department::find()->all(),'id','department_name');

$device_type = ArrayHelper::map(DeviceType::find()->all(),'id','device_type');

$device_code = ArrayHelper::map($deviceModel,'device_id','device_id');

$device_sn = ArrayHelper::map($deviceModel,'serial_no','serial_no');

$device_name = ArrayHelper::map($deviceModel,'id','device_name');

$device_employee_id = ArrayHelper::map(Employee::find()->select('id,user_fullname,department_id')->all(),'id','user_fullname','department.department_name');


$device_type[0] = Yii::t('app','all_device_type');

$department[0] = Yii::t('app','all_department');

$this->title = Yii::t('app','device_report');


$gridColumns = [
	'device_id',
	'serial_no',
	'device_brand',
	'device_model',
	'device_name',
	'memory',
	'cpu',
	'harddisk',
	'monitor',
	'mouse',
	'keyboard',
	'ex_drive',
	'hardware_other',
	'device_ip',
	'mac',
	'date_use',
	'date_expire',
	'device_price',
	'vender',
	'warranty',
	'device_status',
	'other_detail',
	'employee.user_fullname',
	'department.department_name',
	'deviceType.device_type',



];

?>

<h4><i class="glyphicon glyphicon-list-alt"></i> <?= Html::encode($this->title) ?></h4>

<?=$this->render('_menu',['active'=>$search_items['active']]);?>

<div class="col-md-12">
		<br>

			<!-- Nav tabs -->
			<ul  class="nav nav-tabs" role="tablist">

			<li  class="<?= $search_items['active'] == 'type_department' ? 'active':''?>"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?=Yii::t('app','search_department_type')?></a></li>
			<li  class="<?= $search_items['active'] == 'device_id' ? 'active':''?>"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?=Yii::t('app','search_device_code')?></a></li>
			<li  class="<?= $search_items['active'] == 'device_name' ? 'active':''?>"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><?=Yii::t('app','search_device_name')?></a></li>
			<li  class="<?= $search_items['active'] == 'serial_no' ? 'active':''?>"><a href="#sn" aria-controls="sn" role="tab" data-toggle="tab"><?=Yii::t('app','search_sn')?></a></li>
			<li  class="<?= $search_items['active'] == 'employee_id' ? 'active':''?>"><a href="#employee_id" aria-controls="employee_id" role="tab" data-toggle="tab"><?=Yii::t('app','search_user_device')?></a></li>
			<li  class="<?= $search_items['active'] == 'year_use' ? 'active':''?>"><a href="#year_use" aria-controls="year_use" role="tab" data-toggle="tab"><?=Yii::t('app','search_year')?></a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">

			<div role="tabpanel" class="tab-pane <?= $search_items['active'] == 'type_department' ? 'active':''?>" id="profile">

					<div class="row">
						<div class="col-md-10">
							<div class="row">
						 <?php
								if($search_items['active'] == 'type_department'){

									$model->department_id = $search_items['department_id'];

									$model->device_type_id = $search_items['device_type_id'];

									$model->device_status = $search_items['device_status'];
								}
						 ?>
						 <?php $form = ActiveForm::begin(['action'=>['search-type-department'],'method'=>'get']); ?>

							<div class="form-group" >
							<div class="col-md-4">

								 <?=$form->field($model, 'device_type_id')->widget(Select2::classname(), [
									 'data' => $device_type,
									 'language' => Yii::t('app','lang'),
									 'options' => ['placeholder' => Yii::t('app','device_type'),'name'=>'device_type_id'],
									 'pluginOptions' => [
										 'allowClear' => true
									 ],
										'addon' => [
										'prepend' => [
											'content' => '<i class="glyphicon glyphicon-search"></i>',
										],
									]
								 ]);?>

							 </div>
						 </div>

						 <div class="form-group" >
							<div class="col-md-4">
								 <?=$form->field($model, 'department_id')->widget(Select2::classname(), [
									 'data' => $department,
									 'language' => Yii::t('app','lang'),
									 'options' => ['placeholder' => Yii::t('app','department_name'),'name' => 'department_id'],
									 'pluginOptions' => [
										 'allowClear' => true
									 ],
									'addon' => [
										'prepend' => [
											'content' => '<i class="glyphicon glyphicon-search"></i>',
										],
									]
								 ]);?>
							 </div>
						 </div>

						 <div class="form-group" >
						 <div class="col-md-3">
								<?=$form->field($model, 'device_status')->widget(Select2::classname(), [
									'data' => array('enable' => Yii::t('app','normal'),'disable' => Yii::t('app','deprecated') ),
									'language' => Yii::t('app','lang'),
									'hideSearch'=>true,
									'options' => ['placeholder' => Yii::t('app','device_status'),'name'=>'device_status'],
									'pluginOptions' => [
										'allowClear' => true
									],
								]);?>
							</div>
						</div>
						 <div class="form-group">
							 <div class="col-md-1">

								<?=Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.yii::t('app','search'), ['class' => 'btn btn-primary btn-sm','style' => 'margin-top:25px'])?>

							 </div>
						 </div>
						 <?php ActiveForm::end(); ?>
						</div>
					 </div>
					 <div class="col-md-2">
							 <div class="text-right" style="margin-top:38px;">
							 <?php
								 if($search_items['active'] == 'type_department'){
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
								 }
							 ?>
						 </div>

					 </div><!-- end col-->
					</div><!-- end row -->
			</div>

			<div role="tabpanel" class="tab-pane <?= $search_items['active'] == 'device_id' ? 'active':''?>" id="home">
					<div class="row">
						<div class="col-md-8">
							<div class="row">
									<?php $form = ActiveForm::begin(['action'=>['search-id'],'method'=>'get']); ?>

										<div class="form-group">
											<div class="col-md-6">
												<?php
													 if($search_items['active'] == 'device_id'){
																$model->device_id = $search_items['device_id'];
													 }
												?>

												<?=$form->field($model, 'device_id')->widget(Select2::classname(), [
														 'data' => $device_code,
														 'language' =>  Yii::t('app','lang'),
														 'options' => ['placeholder' => Yii::t('app','device_id'),'name' => 'device_id'],
														 'pluginOptions' => [
															 'allowClear' => true
														 ],
														'addon' => [
															'prepend' => [
																'content' => '<i class="glyphicon glyphicon-search"></i>',
															],
														]
													 ]);?>

											</div>
										</div>

									<div class="form-group">
										<div class="col-md-2">
											<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '. Yii::t('app','search'), ['class' => 'btn btn-info input-sm','style' => 'margin-top:25px']) ?>
										</div>
									</div>

						<?php ActiveForm::end(); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="text-right" style="margin-top:38px;">
						<?php
							if($search_items['active'] == 'device_id'){
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
							}
						?>
					</div>

					</div>
					</div><!--end row-->
			</div>

			<div role="tabpanel" class="tab-pane <?= $search_items['active'] == 'device_name' ? 'active':''?>" id="messages">

				<div class="row">
					<div class="col-md-8">
						<div class="row">
							<?php $form = ActiveForm::begin(['action'=>['search-device-name'],'method'=>'get']); ?>

									<div class="form-group">
										<div class="col-md-6">

											<?php
												 if($search_items['active'] == 'device_name'){
															$model->id = $search_items['device_name_id'];
												 }
											?>

											<?=$form->field($model, 'id')->widget(Select2::classname(), [
													 'data' => $device_name,
													 'language' => Yii::t('app','lang'),
													 'options' => ['placeholder' =>  Yii::t('app','device_name'),'name' => 'device_name_id'],
													 'pluginOptions' => [
														 'allowClear' => true
													 ],
													'addon' => [
														'prepend' => [
															'content' => '<i class="glyphicon glyphicon-search"></i>',
														],
													]
												 ])->label(Yii::t('app','device_name'));?>

										</div>
									</div>

								<div class="form-group">
									<div class="col-md-2">
										<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.yii::t('app','search'), ['class' => 'btn btn-info input-sm','style' => 'margin-top:25px']) ?>
									</div>
								</div>

								<?php ActiveForm::end(); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="text-right" style="margin-top:38px;">
					<?php
						if($search_items['active'] == 'device_name'){
						      echo ExportMenu::widget([
							  'dataProvider' => $dataProvider,
							  'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
							  'columns' => $gridColumns,
							  'target' => '_self',
								'clearBuffers' => true,
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
						}
					?>
					</div>
				</div>
				</div><!--end row-->

			</div>

			<div role="tabpanel" class="tab-pane <?= $search_items['active'] == 'serial_no' ? 'active':''?>" id="sn">

				<div class="row">
						<div class="col-md-8">
							<div class="row">
						<?php $form = ActiveForm::begin(['action'=>['search-device-sn'],'method'=>'get']); ?>

					<div class="form-group">
						<div class="col-md-6">

							<?php
								 if($search_items['active'] == 'serial_no'){
											$model->serial_no = $search_items['serial_no'];
								 }
							?>

							<?=$form->field($model, 'serial_no')->widget(Select2::classname(), [
									 'data' => $device_sn,
									 'language' => Yii::t('app','lang'),
									 'options' => ['placeholder' =>  Yii::t('app','search_sn'),'name' => 'serial_no'],
									 'pluginOptions' => [
										 'allowClear' => true
									 ],
									'addon' => [
										'prepend' => [
											'content' => '<i class="glyphicon glyphicon-search"></i>',
										],
									]
								 ]);?>

						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm','style' => 'margin-top:25px']) ?>
						</div>
					</div>

					<?php ActiveForm::end(); ?>
				</div>
				</div>
				<div class="col-md-4">
					<div class="text-right" style="margin-top:38px;">

					<?php
						if($search_items['active'] == 'serial_no'){
              echo ExportMenu::widget([
                  'dataProvider' => $dataProvider,
                  'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                  'columns' => $gridColumns,
	          			'target' => '_self',
									'clearBuffers' => true,
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

						}
					?>
					</div>
				</div>
				</div><!--end row-->

			</div>


			<div role="tabpanel" class="tab-pane <?= $search_items['active'] == 'employee_id' ? 'active':''?>" id="employee_id">

				<div class="row">
					<div class="col-md-8">
						<div class="row">
					 <?php $form = ActiveForm::begin(['action'=>['search-device-employee'],'method'=>'get']); ?>

								<div class="form-group">
									<div class="col-md-6">

										<?php
											 if($search_items['active'] == 'employee_id'){
														$model->employee_id = $search_items['employee_id'];
											 }
										?>

										<?=$form->field($model, 'employee_id')->widget(Select2::classname(), [
												 'data' => $device_employee_id,
												 'language' =>  Yii::t('app','lang'),

												 'options' => ['placeholder' =>  Yii::t('app','search_user_device'),'name' => 'employee_id'],
												 'pluginOptions' => [
													 'allowClear' => true
												 ],
												'addon' => [
													'prepend' => [
														'content' => '<i class="glyphicon glyphicon-search"></i>',
													],
												]
											 ]);?>

									</div>
								</div>

					<div class="form-group">
						<div class="col-md-2">
							<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm','style' => 'margin-top:25px;']) ?>
						</div>
					</div>

					<?php ActiveForm::end(); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="text-right" style="margin-top:38px;">

					<?php
						if($search_items['active'] == 'employee_id'){
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
						}
					?>
					</div>
				</div>
				</div><!--end row-->

			</div><!-- end tap employee -->




			<div role="tabpanel" class="tab-pane <?= $search_items['active'] == 'year_use' ? 'active':''?>" id="year_use">

				<div class="row">
					<div class="col-md-8">
						<div class="row">
								<?php $form = ActiveForm::begin(['action'=>['search-year-use'],'method'=>'get']); ?>

										<?php
											 if($search_items['active'] == 'year_use'){
														$year = $search_items['year_use'];
											 }else{
													$year = date("Y");
											 }
										?>
										<div class="form-group">
													<div class="col-md-4">
														<lable class="control-label"><?=Yii::t('app','search_year')?></label>
														<?php
																echo Select2::widget([
																		'name' => 'year_use',
																		'data' => Job::itemsAlias('year'),
																		'value'=>$year,
																		'hideSearch'=>true,
																		'options' => [
																				'placeholder' => Yii::t('app','year'),

																				],

																		'addon' => [
																				'prepend' => [
																						'content' => '<i class="glyphicon glyphicon-search"></i>',
																				],
																		]
																		]);
																?>
													</div>
										</div>

										<div class="form-group">
											<div class="col-md-2">
												<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm','style' => 'margin-top:20px;']) ?>
											</div>
										</div>

										<?php ActiveForm::end(); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="text-right" style="margin-top:38px;">
					<?php
						if($search_items['active'] == 'year_use'){
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

						}
					?>
					</div>
				</div>
				</div><!--end row-->

			</div><!-- end tap by year -->

			</div>

</div>


<div class="col-md-12">

	<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
	'tableOptions'=>['class'=>'table report-table'],
	'columns' => [
				[
					'class' => 'yii\grid\SerialColumn',
					'header' => Yii::t('app','order'),
						'options' => ['style' => 'width:5%'],
				],
        [
            'attribute'=>'device_id',
            'options' => ['style' => 'width:10%'],
            'format'=>'html'
        ],
				[
						'attribute'=>'serial_no',
						'options' => ['style' => 'width:10%'],
						'format'=>'html'
				],
        [
            'attribute'=>'DeviceName',
            'options' => ['style' => 'width:10%'],
            'format'=>'html'
        ],
        [
            'attribute'=>'deviceType.device_type',
            'options' => ['style' => 'width:15%'],
            'format'=>'html'
        ],

        [
            'attribute'=>'department.department_name',
            'options' => ['style' => 'width:15%'],
            'format'=>'html'
        ],
		[
		'attribute'=>'employee_id',
		'options'=>['style'=>['width'=>'15%']],
		'format'=>'html',
		'value'=>function($model){
			return !empty($model->employee->user_fullname) ? $model->employee->user_fullname : '' ;
		}
        ],
				[
					 'attribute'=>'device_status',
					 'options' => ['style' => 'width:8%'],
					 'format' => 'html',
								 'value'=>function($model){
										 return "<small>".$model->getStatus($model->device_status)."</small>";
								}
				 ],
				 [
		 			'attribute'=>'DeviceRepair',
		 			'options' => ['style' => 'width:8%'],
		 			'format'=>'raw',
		 			'value'=>function($model){

		 				return Html::a('<small>'.Yii::t('app','device_repair').'('.$model->repairCount($model->id).')</small>',['device-list-history-print','id'=>$model->id],['class'=>'btn btn-default btn-xs','target'=>'_blank']);
		 			},
		 		],
				[
				 'attribute'=>'DeviceDetailPrint',
				 'options' => ['style' => 'width:8%'],
				 'format'=>'raw',
				 'value'=>function($model){

					 return Html::a('<small>'.Yii::t('app','device_detail').'</small>',['print-device-detail','id'=>$model->id],['class'=>'btn btn-default btn-xs','target'=>'_blank']);
				 },
			 ],



	],
	//'layout'=>'{items}'
]); ?>

</div>
