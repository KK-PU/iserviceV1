<?php
use app\components\ExcelGrid;
use app\models\Department;
ExcelGrid::widget([

    'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'extension'=>'xlsx',
		'filename'=>'employee',
		'properties' =>[
			'title' 	=> 'employee',
		],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'user_fullname',
			[
              'attribute' => 'user_position',
              'value' => function($model){
                  return !empty($model->user_position) ? $model->user_position : "";
              }
            ],
			[
              'attribute' => 'user_email',
              'value' => function($model){
                  return !empty($model->user_email) ? $model->user_email : "";
              }
            ],
			[
              'attribute' => 'user_phone',
              'value' => function($model){
                  return !empty($model->user_phone) ? $model->user_phone : "";
              }
            ],
            'department.department_name',
			[
              'attribute' => 'username',
              'value' => function($model){
                  return !empty($model->username) ? $model->username : "";
              }
            ],
        ],

    ]);
?>
