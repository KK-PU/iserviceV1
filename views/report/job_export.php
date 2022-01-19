<?php
use app\models\Job;
use app\components\ExcelGrid;

ExcelGrid::widget([  
//\bsource\gridview\ExcelGrid::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'extension'=>'xlsx',
		'filename'=>'export_job_report',
		'properties' =>[
			//'name'	=>'',
			'title' 	=> 'รายงานข้อมูลการทำงาน',
			//'subject' 	=> '',
			//'category'	=> '',
			//'keywords' 	=> '',
			//'manager' 	=> '',
			//'description'=>'BSOURCECODE',
			//'company'	=>'BSOURCE',
		],
          
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'job_date',
                        'options' => ['style' => 'width:10%'],
						'format' => 'html',
						'value' => function($model) {
							$day = explode(" ", $model->job_date);
							return Job::dateShortThai($day['0'])."<br> เวลา : ".substr($day['1'],0,-3);
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
                            'options' => ['style' => 'width:25%'],
                    ],
                     [
                            'attribute'=>'UserName',
                            'options' => ['style' => 'width:15%'],
                            'value'=>'user.fullname',
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

<?php
/*
    echo ExportMenu::widget(
    ['dataProvider'=>$dataExport]);?>
<p></p>
    <?=GridView::widget([
            'dataProvider' => $dataExport,
            'layout'=>'{items}',

    ]);*/
?>
