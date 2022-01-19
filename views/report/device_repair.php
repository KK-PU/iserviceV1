<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Department;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use kartik\select2\Select2;

$department = ArrayHelper::map(Department::find()->all(),'id','department_name');

$this->title = "รายงานประวัติการซ่อมบำรุงอุปกรณ์";
?>
<h4><i class="glyphicon glyphicon-wrench"></i> <?= Html::encode($this->title) ?></h4>

<?=$this->render('_menu',['active'=>'device']);?>
<br>
<div class="row">
	<?php $form = ActiveForm::begin([
		'action' => ['device-repair'],
		'method' => 'get',
		'options'=>['class'=>'form-inline'],
	]); ?>

		<div class="col-md-4">
        	<div class="form-group">
				<?php
					echo Select2::widget([
					'name' => 'department_id',
					'data' => $department,
					'value'=>$department_id,
					'options' => [
						'placeholder' => 'เลือกชื่อหน่วยงาน',

						],
					'addon' => [
						'prepend' => [
							'content' => '<i class="glyphicon glyphicon-search"></i>',
						],
					]
					]);
				?>
			</div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-success btn-sm']) ?>
        </div>

	<?php ActiveForm::end(); ?>
</div>
<br>
	<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'tableOptions'=>['class'=>'table report-table'],
	'columns' => [

		['class' => 'yii\grid\SerialColumn'],
		[
			'attribute'=>'device_name',
			'options' => ['style' => 'width:25%'],
		],
		[
			'attribute'=>'deviceType.device_type',
			'options' => ['style' => 'width:25%'],
		],

		[
			'attribute'=>'department.department_name',
			'options' => ['style' => 'width:25%'],
		],
		
		[
			'attribute'=>'DeviceRepair',
			'options' => ['style' => 'width:20%'],
			'format'=>'raw',
			'value'=>function($model){
					
				return Html::a('รายละเอียด  ('.@$model->repairCount($model->id).')',['repair-report','id'=>$model->id],['class'=>'btn btn-default btn-xs','target'=>'_blank']);
			},
		],

			
	],
	'layout'=>'{items}'
]); ?>
