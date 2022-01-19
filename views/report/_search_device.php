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

$deviceModel = Device::find()->All();

$department = ArrayHelper::map(Department::find()->all(),'id','department_name');

$device_type = ArrayHelper::map(DeviceType::find()->all(),'id','device_type');

$device_code = ArrayHelper::map($deviceModel,'device_id','device_id');

$device_sn = ArrayHelper::map($deviceModel,'serial_no','serial_no');

$device_name = ArrayHelper::map($deviceModel,'id','device_name');

$device_employee_id = ArrayHelper::map(Employee::find()->select('id,user_fullname,department_id')->all(),'id','user_fullname','department.department_name');


$device_type[0] = Yii::t('app','all_device_type');

$department[0] = Yii::t('app','all_department');
//array_push($department,['5']);
?>

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
                   <div class="text-right" style="margin-top:35px;">
                   <?php
                     if($search_items['active'] == 'type_department'){

												echo '<div class="btn-group">
												  <button type="button" class="btn btn-default"><i class="glyphicon glyphicon-print"></i></button>
												  <button type="button" class="btn btn-fefault dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												    <span class="caret"></span>
												    <span class="sr-only">Toggle Dropdown</span>
												  </button>
												  <ul class="dropdown-menu">';

													echo "<li>".Html::a('<i class="glyphicon glyphicon-print"></i>  '.yii::t('app','print'),
	                            [
	                              'search-type-department','department_id' => $search_items['department_id'],
	                              'device_type_id' => $search_items['device_type_id'] ,
	                              'device_status' => $search_items['device_status'],
	                              'print' => 'print'
	                            ],['target' => '_blank'])."</li>";

													echo "<li>".Html::a('<i class="glyphicon glyphicon-download"></i>  '.yii::t('app','export_excel'),
	                            [
	                              'search-type-department','department_id' => $search_items['department_id'],
	                              'device_type_id' => $search_items['device_type_id'] ,
	                              'device_status' => $search_items['device_status'],
	                              'print' => 'export'
	                            ],['target' => '_blank'])."</li>";

												echo '</ul>
												</div>';

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
                <div class="text-right" style="margin-top:35px;">

                <?php
                  if($search_items['active'] == 'device_id'){

										echo '<div class="btn-group">
											<button type="button" class="btn btn-default"><i class="glyphicon glyphicon-print"></i></button>
											<button type="button" class="btn btn-fefault dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu">';

											echo "<li>".Html::a('<i class="glyphicon glyphicon-print"></i> '. Yii::t('app','print'),
	                        [
	                          'search-id',
	                          'device_id' => $search_items['device_id'] ,
	                          'print' => 'print'
	                        ],['target' => '_blank'])."</li>";

													echo "<li>".Html::a('<i class="glyphicon glyphicon-download"></i> '. Yii::t('app','export_excel'),
			                        [
			                          'search-id',
			                          'device_id' => $search_items['device_id'] ,
			                          'print' => 'export'
			                        ],['target' => '_blank'])."</li>";

										echo '</ul>
										</div>';


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
              <div class="text-right" style="margin-top:35px;">
              <?php
                if($search_items['active'] == 'device_name'){

									echo '<div class="btn-group">
										<button type="button" class="btn btn-default"><i class="glyphicon glyphicon-print"></i></button>
										<button type="button" class="btn btn-fefault dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu">';

											echo "<li>".Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),
	                      [
	                        'search-device-name',
	                        'device_name_id' => $search_items['device_name_id'] ,
	                        'print' => 'print'
	                      ],['target' => '_blank'])."</li>";

												echo "<li>".Html::a('<i class="glyphicon glyphicon-download"></i> '. Yii::t('app','export_excel'),
			                      [
			                        'search-device-name',
			                        'device_name_id' => $search_items['device_name_id'] ,
			                        'print' => 'export'
			                      ],['target' => '_blank'])."</li>";

									echo '</ul>
									</div>';

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
							<div class="text-right" style="margin-top:35px;">
              <?php
                if($search_items['active'] == 'serial_no'){

									echo '<div class="btn-group">
										<button type="button" class="btn btn-default"><i class="glyphicon glyphicon-print"></i></button>
										<button type="button" class="btn btn-fefault dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu">';

										echo "<li>".Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),
	                      [
	                        'search-device-sn',
	                        'serial_no' => $search_items['serial_no'] ,
	                        'print' => 'print'
	                      ],['target' => '_blank'])."</li>";

										echo "<li>".Html::a('<i class="glyphicon glyphicon-download"></i> '.Yii::t('app','export_excel'),
												[
													'search-device-sn',
													'serial_no' => $search_items['serial_no'] ,
													'print' => 'export'
												],['target' => '_blank'])."</li>";

									echo '</ul>
									</div>';


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
							<div class="text-right" style="margin-top:35px;">
              <?php
                if($search_items['active'] == 'employee_id'){

									echo '<div class="btn-group">
										<button type="button" class="btn btn-default"><i class="glyphicon glyphicon-print"></i></button>
										<button type="button" class="btn btn-fefault dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu">';

										echo "<li>".Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),
	                      [
	                        'search-device-employee',
	                        'employee_id' => $search_items['employee_id'] ,
	                        'print' => 'print'
	                      ],['target' => '_blank'])."</li>";

												echo "<li>".Html::a('<i class="glyphicon glyphicon-download"></i> '.Yii::t('app','export_excel'),
			                      [
			                        'search-device-employee_id',
			                        'employee_id' => $search_items['employee_id'] ,
			                        'print' => 'export'
			                      ],['target' => '_blank'])."</li>";

									echo '</ul>
									</div>';


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
							<div class="text-right" style="margin-top:35px;">
							<?php
								if($search_items['active'] == 'year_use'){

									echo '<div class="btn-group">
										<button type="button" class="btn btn-default"><i class="glyphicon glyphicon-print"></i></button>
										<button type="button" class="btn btn-fefault dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="caret"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu">';

										echo "<li>".Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),
												[
													'search-year-use',
													'year_use' => $search_items['year_use'] ,
													'print' => 'print'
												],['target' => '_blank'])."</li>";

												echo "<li>".Html::a('<i class="glyphicon glyphicon-download"></i> '.Yii::t('app','export_excel'),
														[
															'search-year-use',
															'year_use' => $search_items['year_use'] ,
															'print' => 'export'
														],['target' => '_blank'])."</li>";

									echo '</ul>
									</div>';


								}
							?>
							</div>
						</div>
						</div><!--end row-->

					</div><!-- end tap by year -->

				  </div>

			</div>
