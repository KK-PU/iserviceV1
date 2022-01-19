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
				  <div class="col-md-6">
					  <?= Html::a(Yii::t('app','request_status'), ['search-status', 'status' => 'request']) ?> <span class="badge"><?= Job::CountStatusByUser('request'); ?></span>

					  <?= Html::a(Yii::t('app','wait_status'), ['search-status', 'status' => 'wait']) ?> <span class="badge"><?= Job::CountStatusByUser('wait'); ?></span>

					  <?= Html::a(Yii::t('app','claim_status'), ['search-status', 'status' => 'claim']) ?> <span class="badge"><?= Job::CountStatusByUser('claim'); ?></span>

					  <?= Html::a(Yii::t('app','process_status'), ['search-status', 'status' => 'process']) ?> <span class="badge"><?= Job::CountStatusByUser('process'); ?></span>

				  </div>
				  <div class="col-md-6 text-right">


						<?= Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app','add_job_order'), ['form-request'], ['class' => 'btn btn-primary btn-sm']) ?>


				  </div>
			</div>

<div class="table-responsive" style="margin-top:10px;">
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

                    $job_number = !empty($model->job_number) ? "<small class='text-primary'> No. ".$model->job_number."</small><br>" : '';

                    return $job_number.Yii::$app->datethai->getDateTime($model->job_date);
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
                  'options' => ['style' => 'width:18%'],
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
      				'attribute'=> 'detail',
      				'headerOptions' => ['style'=>'text-align:center'],
              'contentOptions'=>['class'=>'text-center'],
      				'format'=>'raw',
      				'value'=> function($model){

      				    return Html::button('<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','detail'), [
                      'value' => Url::to('index.php?r=user-request/view&id='.$model->id),
                      'class' => 'btn btn-default btn-xs  view_detail'
                  ]);
      				}
      			]

            ],
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


//check submit search btn
	$('#search_btn').click(function(){

		var search1 = $('#w1').val();
		var search2 = $('#w2').val();

		if(search1 = '' || search2 == ''){
			alert('".Yii::t('app','select_date')."');
			return false;
		}

	});

");



?>
