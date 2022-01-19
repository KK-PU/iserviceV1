<?php
date_default_timezone_set('Asia/Bangkok');
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Employee;
use app\models\User;
use app\models\JobType;
use app\models\Device;
use app\models\Criteria;
use yii\helpers\ArrayHelper;
use janisto\timepicker\TimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Job */
/* @var $form yii\widgets\ActiveForm */

$employee = ArrayHelper::map(Employee::find()->all(),'id','user_fullname','department.department_name');

$job_type = ArrayHelper::map(JobType::find()->all(),'id','job_type_name');

$criteria_risk = ArrayHelper::map(Criteria::find()->all(),'id','criteria_detail');

$device = ArrayHelper::map(Device::find()
->select(['id,CONCAT_WS("",device_id," - ",device_name) AS device_name,device_type_id'])
->where(['device_status' => 'enable'])
->all(),'id','device_name','deviceType.device_type');

$select_user = ArrayHelper::map(User::find()->all(),'id','fullname');

if($model->isNewRecord){

	$model->job_date = date("Y-m-d H:i:s");

}

if(empty($model->job_start_date)){
		$model->job_start_date = date("Y-m-d H:i:s");
}


$disableComplete = (Yii::$app->user->identity->role == 'support' && $model->job_status == 'success') ? true : false;

//$disableComplete = (Yii::$app->user->identity->role == 'support' && $model->job_status == 'success' && $model->job_status == 'wait' && $model->job_status == 'claim' && $model->job_status == 'process' && $model->job_status == 'cancel') ? true : false;

?>

<div class="row">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-md-12">
        <div class="col-md-6">
            <p class="well well-sm"><i class="glyphicon glyphicon-pencil"></i> <?=Yii::t('app','informer')?></p>
                <div class="form-group" >
                     <div class="col-md-12">
                        <label  class="col-md-3"><?php echo Yii::t('app', 'job_request_date')?></label>
                        <div class="col-md-8" >
													<?=
													$form->field($model, 'job_date')->widget(TimePicker::className(), [
															'language' => 'th',
															'mode' => 'datetime',
															'options' => ['class' => 'form-control input-sm',
															'disabled' => (!$model->isNewRecord && Yii::$app->user->identity->role == 'support') ? true : false
															],
															'clientOptions' => [
																	'dateFormat' => 'yy-mm-dd',
																	'timeFormat'=> "HH:mm",
																	'changeMonth' => true,
																	'changeYear' => true,
																	'showButtonPanel'=> true,
															],
													])->label(false);
													?>
                        </div>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-12">
                        <label  class="col-md-3"><?php echo Yii::t('app', 'staff')?></label>
                            <div class="col-md-8" >
                                <?=
                                $form->field($model, 'job_employee_id')->widget(Select2::classname(), [
                                    'data' => $employee,
                                    'language' => 'th',
                                    'options' => [
																			'class' => 'form-control input-sm',
																			'placeholder' => Yii::t('app', 'select_staff'),
																			'disabled' => (!$model->isNewRecord && Yii::$app->user->identity->role == 'support') ? true : false
																		],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false);
                                ?>
                            </div>
                    </div>
                </div>

				<div class="form-group" >
					<div class="col-md-12">
						<label  class="col-md-3"><?=Yii::t('app','phone')?></label>
							<div class="col-md-8" >
								<?= $form->field($model, 'phone')->textInput([
									'class'=>'form-control input-sm',
									'disabled' => $disableComplete
									])->label(false) ?>
							</div>
					</div>
				</div>

        </div>
        <div class="col-md-6">
            <p class="well well-sm"><i class="glyphicon glyphicon-user"></i>  <?php echo Yii::t('app', 'operator')?></p>
                <div class="form-group" >
                    <div class="col-md-12">
                        <label  class="col-md-3 "><?php echo Yii::t('app', 'job_start_date')?></label>
                        <div class="col-md-8" >
                            <?=
                            $form->field($model, 'job_start_date')->widget(TimePicker::className(), [
                                'language' => Yii::t('app', 'lang'),
                                'mode' => 'datetime',
                                'options' => [
																	'class' => 'form-control input-sm',
																	 'disabled' => $disableComplete
																],
                                'clientOptions' => [
                                    'dateFormat' => 'yy-mm-dd',
                                    'timeFormat' => 'HH:mm',
																		'changeMonth' => true,
																		'changeYear' => true,
																		'showButtonPanel'=> true,
                                ]
                            ])->label(false);
                            ?>
                        </div>
                     </div>
                </div>
				<div class="form-group" >
					<div class="col-md-12">
						<label  class="col-md-3"><?php echo Yii::t('app', 'operator')?></label>
						<div class="col-md-8" >

							<?php
														if(!empty($model->user_id)){

															$user =  User::findOne($model->user_id);

														}else{

															$user =  User::findOne(Yii::$app->user->identity->id);
														}

														if(Yii::$app->user->identity->role == 'admin'){

															if(!empty($user)){
																$model->user_id = $user->id;
															}
															echo $form->field($model, 'user_id')->widget(Select2::classname(), [
																	'data' => $select_user,
																	'hideSearch' => 'true',
																	'language' => Yii::t('app','lang'),
																	'options' => ['placeholder' => Yii::t('app','operator')],
																	'pluginOptions' => [
																		'allowClear' => true
																	],
																])->label(false);

														}else{

															echo $user->fullname;

															echo $form->field($model,'user_id')->hiddenInput(['value'=>$user->id])->label(false);

														}

							?>

						</div>
					</div>
				</div>

				<!-- Adding Criteria Choice --> 
				<div class="form-group" >
					<div class="col-md-12">
						<label  class="col-md-3"><?php echo Yii::t('app', 'criteria')?></label>
						<div class="col-md-8" >
						<?php
							if(Yii::$app->user->identity->role == 'admin'){
								echo $form->field($model, 'criteria_id')->widget(Select2::classname(), [
												'data' => $criteria_risk,
												'hideSearch' => 'true',
												'language' => 'th',
												'options' => [
													'placeholder' => Yii::t('app','select_criteria'),
													'disabled' => $disableComplete

												],
												'pluginOptions' => [
													'allowClear' => true
												],
									])->label(false);
							}
                        ?>
						</div>
					</div>
				</div>

        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6" >

            <p class="well well-sm"><i class="glyphicon glyphicon-list-alt"></i> <?=Yii::t('app','problem_info')?></p>
            <div class="form-group" >
                <div class="col-md-12">
                    <label  class="col-md-3"><?=Yii::t('app','job_type')?></label>
                    <div class="col-md-8" >
                        <?=
                        $form->field($model, 'job_type_id')->widget(Select2::classname(), [
                            'data' => $job_type,
                            'hideSearch' => 'true',
                            'language' => 'th',
                            'options' => [
															'placeholder' => Yii::t('app','select_job_type'),
															 'disabled' => $disableComplete

														],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group" >
                <div class="col-md-12">
                    <label  class="col-md-3"><?php echo Yii::t('app', 'device_name')?></label>
                    <div class="col-md-8" >
                        <?=
                        $form->field($model, 'device_id')->widget(Select2::classname(), [
                            'data' => $device,
                            'language' => Yii::t('app', 'lang'),
                            'options' => [
															'placeholder' => Yii::t('app', 'select_device'),
															 'disabled' => $disableComplete
														],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group" >
                <div class="col-md-12">
                    <label  class="col-md-3"><?php echo Yii::t('app', 'problem')?></label>
                    <div class="col-md-8"  >
                        <?= $form->field($model, 'job_detail')->textArea([
													'rows'=>'5',
													'class'=>'form-control input-sm',
													 'disabled' => $disableComplete
													])->label(false) ?>
                    </div>
                </div>
            </div>

						<div class="form-group" >
								<div class="col-md-12">
										<label  class="col-md-3"><?php echo Yii::t('app', 'file')?></label>
										<div class="col-md-4"  >
												<?php echo $form->field($model, 'request_file[]')->fileInput([
													'multiple' => true,
													 'disabled' => $disableComplete
													])->label(false) ?>
										</div>

										<div class="col-md-12">
												<?php
												 $request_file = Yii::$app->upload->getMultipleViewer($model->request_file);
			                   $file = "";

			                   if(!empty($request_file)){

			                     $file = "<div>";
			                        $i = 1;
			                        foreach($request_file as $photo){

			                         if(file_exists(Yii::$app->upload->getUploadPath().$photo)){

			                             $file .= Html::a('<i class="glyphicon glyphicon-link"></i> '.Yii::t('app','file'),Yii::$app->upload->getUploadUrl().$photo, [ 'class' => 'btn btn btn-xs' , 'target' => '_blank']);
																	 $file .= !$disableComplete ? Html::a('<i class="glyphicon glyphicon-trash"></i>',
															              ['id' => $model->id,'delete-request-file','name' => $photo],
															              ['class' => 'text-danger','data-confirm' => 'คุณต้องการลบข้อมูลใช่หรือไม่']) : '';
																	 $i++;
			                         }
			                        }

			                      $file .= "</div>";

			                   }

												 echo $file;
												 ?>
										</div>
								</div>

						</div>

        </div>

		<!-- fome ผลการแก้ไข -->
        <div class="col-md-6">
            <div class="well well-sm"><i class="glyphicon glyphicon-ok"></i> <?php echo Yii::t('app', 'result')?></div>

                <div class="form-group" >
                     <div class="col-md-12">
                        <label  class="col-md-3"><?php echo Yii::t('app', 'job_success_date')?></label>
                        <div class="col-md-8" >
                            <?=
                            $form->field($model, 'job_success_date')->widget(TimePicker::className(), [
                                'language' => Yii::t('app', 'lang'),
                                'mode' => 'datetime',
                                'options' => [
																	'class' => 'form-control input-sm',
																	'disabled' => (Yii::$app->user->identity->role == 'support') ? true : false
																],
                                'clientOptions' => [
                                    'dateFormat' => 'yy-mm-dd',
                                    'timeFormat' => 'HH:mm',
																		'changeMonth' => true,
																		'changeYear' => true,
																		'showButtonPanel'=> true,
                                ]
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>

            <div class="form-group" >
                <div class="col-md-12">
                    <label  class="col-md-3"><?=Yii::t('app','solution')?></label>
                    <div class="col-md-8"  >
                        <?= $form->field($model, 'job_how_to_fix')->textArea([
														'rows'=>'4',
														'class'=>'form-control input-sm',
														'disabled' => $disableComplete
													])->label(false) ?>
                    </div>
                </div>
            </div>

                <div class="form-group" >
                     <div class="col-md-12">
                        <label  class="col-md-3"><?=Yii::t('app','price')?></label>
                            <div class="col-md-4" >
                                <?= $form->field($model, 'price')->textInput([
																	'value'=>($model->price) == NULL ? '0': $model->price ,
																	'class'=>'form-control input-sm',
																		 'disabled' => $disableComplete
																	])->label(false) ?>
                            </div>

                    </div>
                </div>

                <div class="form-group" >
                     <div class="col-md-12">
                        <label  class="col-md-3"><?=Yii::t('app','status')?></label>
                            <div class="col-md-5" >

                                <?= $form->field($model, 'job_status')->dropDownList([
																	 /*'request'=> Yii::t('app','request_status'),*/
																	 'wait' => Yii::t('app','wait_status'),
																	 'claim' => Yii::t('app','claim_status'),
																	 'process' => Yii::t('app','process_status'),
																	 'success'=> Yii::t('app','success_status'),
																	 'cancel'=> Yii::t('app','cancel_status'),
																	 ],['disabled' => $disableComplete])->label(false) ?>

                            </div>
                    </div>
                </div>

								<div class="form-group" >
										<div class="col-md-12">
												<label  class="col-md-3"><?=Yii::t('app','file')?></label>
												<div class="col-md-4"  >
														<?php echo $form->field($model, 'success_file[]')->fileInput([
															'multiple' => true,
															'disabled' => $disableComplete
															])->label(false) ?>
												</div>
												<div class="col-md-12">
													<?php
													 $success_file = Yii::$app->upload->getMultipleViewer($model->success_file);
				                   $file = "";

				                   if(!empty($success_file)){

				                     $file = "<div>";
				                        $i = 1;
				                        foreach($success_file as $photo){

				                         if(file_exists(Yii::$app->upload->getUploadPath().$photo)){

				                             $file .= Html::a('<i class="glyphicon glyphicon-link"></i> '.Yii::t('app','file'),Yii::$app->upload->getUploadUrl().$photo, [ 'class' => 'btn btn btn-xs' , 'target' => '_blank']);
																		 $file .= !$disableComplete ? Html::a('<i class="glyphicon glyphicon-trash"></i>',
																              ['id' => $model->id,'delete-success-file','name' => $photo],
																              ['class' => 'text-danger','data-confirm' => 'คุณต้องการลบข้อมูลใช่หรือไม่']) : '';
																		 $i++;
				                         }
				                        }

				                      $file .= "</div>";

				                   }

													 echo $file;
													 ?>
												</div>
										</div>
								</div>
        </div>
		<!-- ปิด fome ผลการแก้ไข -->

        <div class="form-group">

            <div class="col-md-12">
                <hr>
                <?php
                if (!$model->isNewRecord) {

					if(Yii::$app->user->identity->role == 'admin'){
						echo Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('app','delete'), ['delete', 'id' => $model->id, 'start_search' => Yii::$app->request->get('start_search'), 'end_search' => Yii::$app->request->get('end_search')], [
							'title' => Yii::t('yii', 'Delete'),
							'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
							'data-method' => 'post',
							'data-pjax' => '0',
							'class' => 'btn btn-danger'
						]);
					}
					echo "&nbsp;";
							echo Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'), ['print', 'id' => $model->id], ['target' => '_blank', 'class' => 'btn btn-info']);

									echo "<div class='pull-right'>";
									if(!$disableComplete){
										echo Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save_change'), ['class' => 'btn btn-primary']);
										echo "&nbsp;";
									}
										echo Html::a('<i class="glyphicon glyphicon-remove"></i> '.Yii::t('app','cancel'), ['index', 'start_search' => $start_search, 'end_search' => $end_search , 'page' => $page ], ['class' => 'btn btn-default']);
									echo "</div>";

                }else{
									echo "<div class='pull-right'>";
										echo Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app','save'), ['class' => 'btn btn-success']);
										echo "&nbsp;";
										echo Html::a('<i class="glyphicon glyphicon-remove"></i> '.Yii::t('app','cancel'), ['index'], ['class' => 'btn btn-default']);
									echo "</div>";


								}
                ?>





            </div>

        </div>

    </div>
<?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("
	$(function(){
		$('#job').addClass('active');
	});
");
?>
