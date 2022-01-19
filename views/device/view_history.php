<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app','device_name').' : '.$device->device_name ;
?>

<div class="row">
<div class="col-md-6">
	<p><?= Html::encode($this->title) ?></p>
</div>
<div class="col-md-6">
	<div class="pull-right">
		<?php
			echo Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),['report/device-list-history-print', 'id' => $id], ['class'=>'btn btn-info btn-sm','target' => '_blank']);
		?>
		<?=Html::a('<i class="glyphicon glyphicon-off"></i> '.Yii::t('app','close'),null,['class'=>'btn btn-default btn-sm','data-dismiss'=>'modal']);?>
	</div>
</div>
</div>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions'=>['class'=>'table report-table','width'=>'100%'],
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'job_date',
								'options' => ['width'=>'10%'],
                'contentOptions' => ['width' => '10%'],
								'format' => 'html',
                'value' => function($model) {
									return Yii::$app->datethai->getDateTime($model->job_date);
								}
            ],
						[
								'attribute' => 'employee.user_fullname',
								'options' => ['style' => 'width:15%'],
										'format'=>'raw',
										'value'=>function($model){

											$name =  !empty($model->employee->user_fullname) ? $model->employee->user_fullname : " ";
											$department =  !empty($model->employee->department->department_name) ? $model->employee->department->department_name : " ";

													 return "<p>".$name."<br><small>".$department."</small></p>";
										}
						],
            [
                'attribute'=>'job_detail',

                'contentOptions' => ['width' => '18%'],
            ],
            [
                'attribute'=>'job_how_to_fix',

                'contentOptions' => ['width' => '18%'],
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
							'attribute'=>'price',
							'options' => ['width'=>'8%'],
							'contentOptions' => ['style' => 'text-align:right','width'=>'8%'],
							'value'=>function($model){
								return number_format($model->price);
							}
						],
            [
                'attribute'=>'job_status',
								'format'=>'html',
								'contentOptions' => ['width' => '8%'],
                'value'=>function($model){

										return Yii::$app->getdata->getStatusColor($model->job_status);
                },
            ],
    ],
    'layout'=>'{items}',
]); ?>
