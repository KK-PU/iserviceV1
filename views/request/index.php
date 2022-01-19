<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use app\models\Employee;
use app\models\Job;
use kartik\growl\Growl;

$this->title = Yii::t('app','job_order_list');
//$this->params['breadcrumbs'][] = $this->title;

$employee = ArrayHelper::map(Employee::find()->all(),'id','user_fullname','department.department_name');

if(Yii::$app->session->hasFlash('contactFormSubmitted')):
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success'),
        'showSeparator' => true,
        'body' => Yii::t('app','save_success_alert')
    ]);
endif;

?>

	<div class="job-index">
    <h4><i class="glyphicon glyphicon-tasks"></i> <?= Html::encode($this->title); ?>  </h4>
	<hr>

			<div class="row">

				<?php $form = ActiveForm::begin();?>

				<div class="form-group">
					<div class="col-md-4 col-xs-12">

							<?=
							$form->field($model, 'job_employee_id')->widget(Select2::classname(), [
								'data' => $employee,
								'language' => Yii::t('app','lang'),
								'options' => ['class' => 'form-control input-sm', 'placeholder' => Yii::t('app','find_staff')],
								'pluginOptions' => [
									'allowClear' => true
								],
								'addon' => [
									'prepend' => [
										'content' => '<i class="glyphicon glyphicon-search"></i>',
									],
								]

							])->label(false);
							?>

					</div>
				</div>

				<div class="form-group">
					<div class="col-md-2 col-xs-6">
						<?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> '.Yii::t('app','search'), ['class' => 'btn btn-info input-sm']) ?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6 col-xs-6">
            <p>
						  <?= Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app','add_job_order'), ['form-request'], ['class' => 'btn btn-primary btn-sm pull-right']) ?>
            </p>
					</div>
				</div>

				<?php ActiveForm::end(); ?>

			</div>
<br>
<div class="table-responsive">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-hover table-bordered job-request'],
        'rowOptions' => ['class' => 'job'],
        'columns' => [

            //['class' => 'yii\grid\SerialColumn'],
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
                'options' => ['style' => 'width:15%'],
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

                  $request_file = Yii::$app->upload->getMultipleViewer($model->request_file);
                   $file = "";

                   if(!empty($request_file)){

                     $file = "<div style='margin-top:8px;'>";
                        $i = 1;
                        foreach($request_file as $photo){

                         if(file_exists(Yii::$app->upload->getUploadPath().$photo)){

                             $file .= Html::a('<i class="glyphicon glyphicon-link"></i> '.Yii::t('app','file'),Yii::$app->upload->getUploadUrl().$photo, ['target' => '_blank']).'&nbsp;';
                             $i++;
                         }
                        }

                      $file .= "</div>";

                   }
                    return $model->job_detail."<br><small>".$file."</small>";
                }
            ],
            [
                'attribute' => 'job_how_to_fix',
                'options' => ['style' => 'width:18%'],
                'format' => 'raw',
                'value' => function($model){

                  $success_file = Yii::$app->upload->getMultipleViewer($model->success_file);
                   $file = "";

                   if(!empty($success_file)){

                     $file = "<div style='margin-top:8px;'>";
                        $i = 1;
                        foreach($success_file as $photo){

                         if(file_exists(Yii::$app->upload->getUploadPath().$photo)){

                             $file .= Html::a('<i class="glyphicon glyphicon-link"></i> '.Yii::t('app','file'),Yii::$app->upload->getUploadUrl().$photo, ['target' => '_blank']).'&nbsp;';
                             $i++;
                         }
                        }

                      $file .= "</div>";

                   }
                    return $model->job_how_to_fix."<br><small>".$file."</small>";
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
                'attribute' => 'job_status',
                'headerOptions' =>['class'=>'text-center'],
                'contentOptions' =>['class' => 'text-center'],
                'options' => ['style' => 'width:8%;'],
        				'format'=>'html',
                'value' => function($model) {
        					return Job::getStatus($model->job_status);
        				},
            ],
          			[
          				'attribute'=>'detail',
          				'headerOptions' => ['style'=>'text-align:center'],
          				'format'=>'raw',
          				'value'=> function($model){

          				    return Html::button('<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','detail'), [
                          'value' => Url::to('index.php?r=request/view&id='.$model->id),
                          'class' => 'btn btn-default btn-xs  view_detail'
                      ]);

          				}
          			]

                ],
            //'layout' => '{items}'
            ]);
            ?>
      </div>
</div>
<?php
//show modal
    Modal::begin([
        'header' => '<h4>'.Yii::t('app','detail').'</h4>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
        echo "<div id='content'></div>";
    Modal::end();


$this->registerJs("

    setInterval(function () {
      location.reload();
    }, 120000);


    //show modal for view detail
    $('.view_detail').click(function() {

    	$('#modal').modal('show')
    		.find('#content')
    		.load($(this).attr('value'));
    });


    //set for emply data
    $('.not-set').text('');


");



?>
