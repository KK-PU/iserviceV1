<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Job;

$this->title = "รายงานทะเบียนอุปกรณ์";
?>
<h4><?= Html::encode($this->title) ?> </h4>

    <div class="pull-right margin-print" id="non-printable">
	
		<?=Html::a('<i class="glyphicon glyphicon-save"></i> Export Excel',
		['device-export','device_type_id'=>$device_type_id,'department_id'=>$department_id] ,['class' => 'btn btn-default btn-sm'])?>
				
				
        <button class="btn btn-info btn-sm" onclick="return window.print();">พิมพ์รายงาน</button>
        <button class="btn btn-default btn-sm" onclick="return window.close();">ปิด</button>
        
    </div>

	<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'device_id',
            'options' => ['style' => 'width:15%'],
            'format'=>'html'
        ],
        [
            'attribute'=>'DeviceName',
            'options' => ['style' => 'width:35%'],
            'format'=>'html'
        ],
        [
            'attribute'=>'deviceType.device_type',
            'options' => ['style' => 'width:15%'],
            'format'=>'html'
        ],

        [
            'attribute'=>'department.department_name',
            'options' => ['style' => 'width:15%'],
            'format'=>'html'
        ],
        [
            'attribute'=>'device_price',
            'options' => ['style' => 'width:5%;'],
            'contentOptions' => ['style' => 'text-align:right'],
            'format'=>'html',
            'value'=>function($model){
                return number_format($model->device_price);
            },
        ],
        
         [
			'attribute'=>'device_status',
			'options' => ['style' => 'width:10%'],
            'value'=>function($model){
                return $model->device_status == 'disable' ?' เลิกใช้งาน ' : 'ใช้งานปกติ';
           }
		],

	],
	'layout'=>'{items}'
]); ?>