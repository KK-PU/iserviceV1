<?php
use app\components\ExcelGrid;
use app\models\Job;
ExcelGrid::widget([  
        'dataProvider' => $dataProvider,
		'extension'=>'xlsx',
		'filename'=>'employee_report',
		'properties' =>[
			'title' 	=> 'employee_report ',
		],
            'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'job_date',
                        'options' => ['style' => 'width:10%'],
						'format' => 'html',
						'value' => function($model) {
							
							$day = explode(" ", $model->job_date);
							
							if(!empty($day['0']) && !empty($day['1'])){
								
								return Job::dateShortThai($day['0'])."<br> เวลา : ".substr($day['1'],0,-3);
							}
							
							return "";
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
                            'attribute'=>'price',
                            'options' => ['style' => 'width:5%'],
                     ],
                    [
                            'attribute'=>'job_status',
                            'format'=>'html',
                            'options' => ['style' => 'width:10%'],
                            'value'=>function($model){
                                    return Job::getStatus($model->job_status);
                            },
                    ],
            ],
         
    ]);
?>

