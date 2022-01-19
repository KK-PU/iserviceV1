<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\Job;
use app\models\Request;
use kartik\growl\Growl;

$this->title = Yii::t('app','job_page_header');

if(Yii::$app->session->hasFlash('save')):
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success'),
        'showSeparator' => true,
        'body' => Yii::t('app','save_success_alert')
    ]);
endif;

if(Yii::$app->session->hasFlash('delete')):
    echo Growl::widget([
        'type' => Growl::TYPE_DANGER,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success'),
        'showSeparator' => true,
        'body' => Yii::t('app','delete_success_alert')
    ]);
endif;
?>

<div class="job-index">

    <h4><i class="glyphicon glyphicon-tasks"></i> <?= Html::encode($this->title); ?> : <?= $title ?></h4>

    <?php echo $this->render('_search', ['start_search' => $start_search, 'end_search' => $end_search]); ?>

    <div class="row status">

        <div class="col-md-8">

              <?= Html::a(Yii::t('app','request_status'), ['search-status', 'status' => 'request']) ?> <span class="badge"><?= Job::CountStatus('request'); ?></span>
              <?= Html::a(Yii::t('app','wait_status'), ['search-status', 'status' => 'wait']) ?> <span class="badge"><?= Job::CountStatus('wait'); ?></span>
              <?= Html::a(Yii::t('app','claim_status'), ['search-status', 'status' => 'claim']) ?> <span class="badge"><?= Job::CountStatus('claim'); ?></span>
              <?= Html::a(Yii::t('app','process_status'), ['search-status', 'status' => 'process']) ?> <span class="badge"><?= Job::CountStatus('process'); ?></span>

        </div>

    </div>
    <div class="table-responsive">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-hover job-table'],
        'rowOptions' => ['class' => 'job'],
        'columns' => [
            [
                'attribute' => 'job_date',
                'options' => ['style' => 'width:8%'],
        		'format' => 'html',
                'value' => function($model) {
                    $job_number = !empty($model->job_number) ? "<small class='text-primary'> NO. ".$model->job_number."</small><br>" : '';
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
                'options' => ['style' => 'width:15%'],
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
                'attribute' => 'job_success_date',
                'options' => ['style' => 'width:8%'],
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
        					  return Yii::$app->getdata->getStatusColor($model->job_status);
        				},
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width:2%;'],
                'template' => '{update}',
                'buttons' => [

                    'update' => function($url, $model, $key)  use ($start_search,$end_search,$page) {

        						if(Yii::$app->user->identity->role == 'admin'){

        							return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model->id,
        							'start_search' => $start_search,
        							'end_search' => $end_search,
                      'page' => $page],
        							['class' => 'btn btn-warning btn-xs']);

        						}else{

        							if($model->job_status == 'request'){
        								return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model->id,
        								'start_search' =>  $start_search,
        								'end_search' => $end_search],
        								['class' => 'btn btn-warning btn-xs']);

        							}else{

        								return Yii::$app->user->identity->id == $model->user_id ?

              								Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update', 'id' => $model->id,
                                'start_search' =>  $start_search,
                                'end_search' => $end_search,
                                'page' => $page],
              								['class' => 'btn btn-warning btn-xs']) :

              								Html::a('<i class="glyphicon glyphicon-user"></i>', NULL,
              								['class' => 'btn btn-default btn-xs',
              								 'disabled' => 'disabled']);
        							}
						}

                    },
                        ]
                    ],
                ],
            ]);
            ?>
    </div>
</div>
<?php

$this->registerJs("

    setInterval(function () {
      location.reload();
    }, 120000);

    $('.view_detail').click(function() {
    	$('#modal').modal('show')
    		.find('#content')
    		.load($(this).attr('value'));
    });

    $('.not-set').text('');

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
