<?php
use app\components\ExcelGrid;

ExcelGrid::widget([
//\bsource\gridview\ExcelGrid::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'extension'=>'xlsx',
		'filename'=>'export_device_report',
		'properties' =>[
			//'name'	=>'',
			'title' 	=> Yii::t('app','device_register'),
			//'subject' 	=> '',
			//'category'	=> '',
			//'keywords' 	=> '',
			//'manager' 	=> '',
			//'description'=>'BSOURCECODE',
			//'company'	=>'BSOURCE',
		],

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        [
          'attribute' => 'device_id',
          'value' => function($model){
            return !empty($model->device_id) ? $model->device_id : "";
          }
        ],
        [
          'attribute' => 'serial_no',
          'value' => function($model){
            return !empty($model->serial_no) ? $model->serial_no : "";
          }
        ],
        [
          'attribute' => 'device_brand',
          'value' => function($model){
            return !empty($model->device_brand) ? $model->device_brand : "";
          }
        ],
        [
          'attribute' => 'device_model',
          'value' => function($model){
            return !empty($model->device_model) ? $model->device_model : "";
          }
        ],
        [
          'attribute' => 'device_name',
          'value' => function($model){
            return !empty($model->device_name) ? $model->device_name : "";
          }
        ],
        [
          'attribute' => 'memory',
          'value' => function($model){
            return !empty($model->memory) ? $model->memory : "";
          }
        ],
        [
          'attribute' => 'cpu',
          'value' => function($model){
            return !empty($model->cpu) ? $model->cpu : "";
          }
        ],
        [
          'attribute' => 'harddisk',
          'value' => function($model){
            return !empty($model->harddisk) ? $model->harddisk : "";
          }
        ],
        [
          'attribute' => 'monitor',
          'value' => function($model){
            return !empty($model->monitor) ? $model->monitor : "";
          }
        ],
        [
          'attribute' => 'mouse',
          'value' => function($model){
            return !empty($model->mouse) ? $model->mouse : "";
          }
        ],
        [
          'attribute' => 'keyboard',
          'value' => function($model){
            return !empty($model->keyboard) ? $model->keyboard : "";
          }
        ],
        [
          'attribute' => 'ex_drive',
          'value' => function($model){
            return !empty($model->ex_drive) ? $model->ex_drive : "";
          }
        ],
        [
          'attribute' => 'hardware_other',
          'value' => function($model){
            return !empty($model->hardware_other) ? $model->hardware_other : "";
          }
        ],
        [
          'attribute' => 'device_ip',
          'value' => function($model){
            return !empty($model->device_ip) ? $model->device_ip : "";
          }
        ],
        [
          'attribute' => 'mac',
          'value' => function($model){
            return !empty($model->mac) ? $model->mac : "";
          }
        ],
        [
          'attribute' => 'date_use',
          'value' => function($model){
            return !empty($model->date_use) ? $model->date_use : "";
          }
        ],
        [
          'attribute' => 'date_expire',
          'value' => function($model){
            return !empty($model->date_expire) ? $model->date_expire : "";
          }
        ],
        [
          'attribute' => 'device_price',
          'value' => function($model){
            return !empty($model->device_price) ? $model->device_price : "";
          }
        ],
        [
          'attribute' => 'vender',
          'value' => function($model){
            return !empty($model->vender) ? $model->vender : "";
          }
        ],
        [
          'attribute' => 'warranty',
          'value' => function($model){
            return !empty($model->warranty) ? $model->warranty : "";
          }
        ],
        [
          'attribute' => 'device_status',
          'value' => function($model){
            return !empty($model->device_status) ? $model->device_status : "";
          }
        ],
        [
          'attribute' => 'other_detail',
          'value' => function($model){
            return !empty($model->other_detail) ? $model->other_detail : "";
          }
        ],
        'deviceType.device_type',
        'department.department_name',
        'employee.user_fullname'
    ],

    ]);
?>
