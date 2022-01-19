<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app','device_register');
?>
 <h4><?= Html::encode($this->title)?></h4>

     <div class="pull-right margin-print" id="non-printable">
        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>
    </div>

    	<?= GridView::widget([
    	'dataProvider' => $dataProvider,
    	'tableOptions'=>['class'=>'table'],
    	'columns' => [
        		[
              'class' => 'yii\grid\SerialColumn',
              'header' => Yii::t('app','order'),
                'options' => ['style' => 'width:5%'],
            ],
            [
                'attribute'=>'device_id',
                'options' => ['style' => 'width:10%'],
                'format'=>'html'
            ],
			[
					'attribute'=>'serial_no',
					'options' => ['style' => 'width:15%'],
					'format'=>'html'
			],
            [
                'attribute'=>'DeviceName',
                'options' => ['style' => 'width:15%'],
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
		'attribute'=>'employee_id',
		'options'=>['style'=>['width'=>'15%']],
		'format'=>'html',
		'value'=>function($model){
			return !empty($model->employee->user_fullname) ? $model->employee->user_fullname : '' ;
		}
        ],
    				[
    					 'attribute'=>'device_status',
    					 'options' => ['style' => 'width:15%'],
    					 'format' => 'html',
    								 'value'=>function($model){
    										 return "<small>".$model->getStatus($model->device_status)."</small>";
    								}
    				 ],
    	],
    	'layout'=>'{items}',
    ]); ?>
