<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Department;
use app\models\DeviceType;
use app\models\Device;
use app\models\Employee;

$deviceModel = Device::find()->All();

$department = ArrayHelper::map(Department::find()->all(),'id','department_name');

$device_type = ArrayHelper::map(DeviceType::find()->all(),'id','device_type');

$device_code = ArrayHelper::map($deviceModel,'device_id','device_id');

$device_sn = ArrayHelper::map($deviceModel,'serial_no','serial_no');

$device_name = ArrayHelper::map($deviceModel,'id','device_name');

$device_employee_id = ArrayHelper::map(Employee::find()->all(),'id','user_fullname','department.department_name');

$model->department_id = $get_select['department_id'];

$model->device_type_id = $get_select['device_type_id'];

$this->title = Yii::t('app','device_register');

$device_type[0] = Yii::t('app','all_device_type');

$department[0] = Yii::t('app','all_department');

?>

    <h4><i class="glyphicon glyphicon-list-alt"></i> <?= Html::encode($this->title) ?>

		<?= Yii::$app->user->identity->role == 'admin' ?  Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app','add_device'), ['create'], ['class' => 'btn btn-success btn-sm pull-right']) :'' ?></h4>

		<div class="row">
			<div class="col-md-12">
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="<?= $active == 'device_id' ? 'active':''?>"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?=Yii::t('app','search_device_code')?></a></li>
					<li role="presentation" class="<?= $active == 'device_type' ? 'active':''?>"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?=Yii::t('app','search_department_type')?></a></li>
					<li role="presentation" class="<?= $active == 'device_name' ? 'active':''?>"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><?=Yii::t('app','search_device_name')?></a></li>
					<li role="presentation" class="<?= $active == 'serial_no' ? 'active':''?>"><a href="#sn" aria-controls="sn" role="tab" data-toggle="tab"><?=Yii::t('app','search_sn')?></a></li>
					<li role="presentation" class="<?= $active == 'employee_id' ? 'active':''?>"><a href="#employee_id" aria-controls="employee_id" role="tab" data-toggle="tab"><?=Yii::t('app','search_user_device')?></a></li>

				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">

					<div role="tabpanel" class="tab-pane <?= $active == 'device_id' ? 'active':''?>" id="home">
							<div class="row">

								 <?php $form = ActiveForm::begin(['action'=>['search-id'],'method'=>'get']); ?>

								<div class="form-group">
									<div class="col-md-4">
									<?php
										if(isset($_GET['Device']['device_id'])){
											$model->device_id = $_GET['Device']['device_id'];
										}
									?>
										<?=$form->field($model, 'device_id')->widget(Select2::classname(), [
											   'data' => $device_code,
											   'language' => 'th',
											   'options' => ['placeholder' => Yii::t('app','search_device_code')],
											   'pluginOptions' => [
												   'allowClear' => true
											   ],
												'addon' => [
													'prepend' => [
														'content' => '<i class="glyphicon glyphicon-search"></i>',
													],
												]
										   ])->label(false);?>

									</div>
								</div>

								<div class="form-group">
									<div class="col-md-2">
										<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm']) ?>
									</div>
								</div>

								<?php ActiveForm::end(); ?>
							</div>
					</div>

					<div role="tabpanel" class="tab-pane <?= $active == 'device_type' ? 'active':''?>" id="profile">

							<div class="row">
							   <?php $form = ActiveForm::begin(['action'=>['search-device'],'method'=>'get']); ?>

							   	<div class="form-group" >
									<div class="col-md-4">

									   <?=$form->field($model, 'device_type_id')->widget(Select2::classname(), [
										   'data' => $device_type,
										   'language' => Yii::t('app','lang'),
										   'options' => ['placeholder' => Yii::t('app','device_type')],
										   'pluginOptions' => [
											   'allowClear' => true
										   ],
										   	'addon' => [
												'prepend' => [
													'content' => '<i class="glyphicon glyphicon-search"></i>',
												],
											]
									   ])->label(false);?>

								   </div>
							   </div>

							   <div class="form-group" >
									<div class="col-md-4">
									   <?=$form->field($model, 'department_id')->widget(Select2::classname(), [
										   'data' => $department,
										   'language' => Yii::t('app','lang'),
										   'options' => ['placeholder' => Yii::t('app','department_name')],
										   'pluginOptions' => [
											   'allowClear' => true
										   ],

											'addon' => [
												'prepend' => [
													'content' => '<i class="glyphicon glyphicon-search"></i>',
												],
											]

									   ])->label(false);?>
								   </div>
							   </div>

							   <div class="form-group">
								   <div class="col-md-4">

										<?=Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-primary btn-sm'])?>

								   </div>
							   </div>
							   <?php ActiveForm::end(); ?>
							</div>
					</div>
					<div role="tabpanel" class="tab-pane <?= $active == 'device_name' ? 'active':''?>" id="messages">

						<div class="row">

							 <?php $form = ActiveForm::begin(['action'=>['device-name'],'method'=>'get']); ?>

							<div class="form-group">
								<div class="col-md-4">

									<?php
										if(isset($_GET['Device']['id'])){
											$model->id = $_GET['Device']['id'];
										}
									?>

									<?=$form->field($model, 'id')->widget(Select2::classname(), [
										   'data' => $device_name,
										   'language' => Yii::t('app','lang'),
										   'options' => ['placeholder' => Yii::t('app','search_device_name')],
										   'pluginOptions' => [
											   'allowClear' => true
										   ],
											'addon' => [
												'prepend' => [
													'content' => '<i class="glyphicon glyphicon-search"></i>',
												],
											]
									   ])->label(false);?>

								</div>
							</div>

							<div class="form-group">
								<div class="col-md-2">
									<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm']) ?>
								</div>
							</div>

							<?php ActiveForm::end(); ?>
						</div>

					</div>

					<div role="tabpanel" class="tab-pane <?= $active == 'serial_no' ? 'active':''?>" id="sn">

						<div class="row">

							 <?php $form = ActiveForm::begin(['action'=>['device-sn'],'method'=>'get']); ?>

							<div class="form-group">
								<div class="col-md-4">

									<?php
										if(isset($_GET['Device']['serial_no'])){
											$model->serial_no = $_GET['Device']['serial_no'];
										}
									?>

									<?=$form->field($model, 'serial_no')->widget(Select2::classname(), [
										   'data' => $device_sn,
										   'language' => Yii::t('app','lang'),
										   'options' => ['placeholder' => Yii::t('app','search_sn')],
										   'pluginOptions' => [
											   'allowClear' => true
										   ],
											'addon' => [
												'prepend' => [
													'content' => '<i class="glyphicon glyphicon-search"></i>',
												],
											]
									   ])->label(false);?>

								</div>
							</div>

							<div class="form-group">
								<div class="col-md-2">
									<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm']) ?>
								</div>
							</div>

							<?php ActiveForm::end(); ?>
						</div>

					</div>


					<div role="tabpanel" class="tab-pane <?= $active == 'employee_id' ? 'active':''?>" id="employee_id">

						<div class="row">

							 <?php $form = ActiveForm::begin(['action'=>['device-employee'],'method'=>'get']); ?>

							<div class="form-group">
								<div class="col-md-4">

									<?php
										if(isset($_GET['Device']['employee_id'])){
											$model->employee_id = $_GET['Device']['employee_id'];
										}
									?>

									<?=$form->field($model, 'employee_id')->widget(Select2::classname(), [
										   'data' => $device_employee_id,
										   'language' => Yii::t('app','lang'),

										   'options' => ['placeholder' => Yii::t('app','search_user_device')],
										   'pluginOptions' => [
											   'allowClear' => true
										   ],
											'addon' => [
												'prepend' => [
													'content' => '<i class="glyphicon glyphicon-search"></i>',
												],
											]
									   ])->label(false);?>

								</div>
							</div>

							<div class="form-group">
								<div class="col-md-2">
									<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm']) ?>
								</div>
							</div>

							<?php ActiveForm::end(); ?>
						</div>

					</div>

				  </div>

			</div>
		</div>
