<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\growl\Growl;

$this->title = Yii::t('app','import_setting');

if(Yii::$app->session->hasFlash('import_success')):
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'icon' => 'glyphicon glyphicon-ok-sign',
        'title' => Yii::t('app','success_status'),
        'showSeparator' => true,
        'body' => Yii::t('app','save_success_alert')
    ]);
endif;


?>

<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading"><i class="glyphicon glyphicon-import"></i> <?= Html::encode($this->title); ?></div>

    <div class="panel-body">

		<div class="well">
			<p><b><?=Yii::t('app','import_des')?></b></p>
			<p><u><?=Yii::t('app','import_data')?></u></p>
				<ul>
					<li><?=Yii::t('app','import_1')?>
					<li><?=Yii::t('app','import_2')?>
					<li><?=Yii::t('app','import_3')?>
					<li><?=Yii::t('app','import_4')?>
					<li><?=Yii::t('app','import_5')?>
				</ul>
		</div>


        <table class="table table-bordered report-table">
			<thead>
				<tr>
					<th width="5%" style="text-align:center"><?=Yii::t('app','order')?></th>
					<th width="55%"><?=Yii::t('app','import_export')?></th>
					<th width="20%" style="text-align:center"><?=Yii::t('app','export')?></th>
					<th width="20%" style="text-align:center"><?=Yii::t('app','import')?></th>
				</tr>
			</thead>
			<tr>
				<td align="center">1</td>
				<td><?=Yii::t('app','device_type')?></td>
				<td class="text-center"><?=Html::a('device_type.xlxs','example/device_type.xlsx',['class'=>'']);?></td>
				<td class="text-center"><?=Html::a('<i class="glyphicon glyphicon-import"></i> '.Yii::t('app','import').' Excel',['device-type'],['class'=>'btn btn-info btn-xs']);?></td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td><?=Yii::t('app','department_name')?></td>
				<td class="text-center"><?=Html::a('department.xlsx','example/department.xlsx',['class'=>'']);?></td>
				<td class="text-center"><?=Html::a('<i class="glyphicon glyphicon-import"></i> '.Yii::t('app','import').' Excel',['department'],['class'=>'btn btn-info btn-xs']);?></td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td><?=Yii::t('app','staff')?></td>
				<td class="text-center"><?=Html::a('employee.xlxs','example/employee.xlsx',['class'=>'']);?></td>
				<td class="text-center"><?=Html::a('<i class="glyphicon glyphicon-import"></i> '.Yii::t('app','import').' Excel',['employee'],['class'=>'btn btn-info btn-xs']);?></td>
			</tr>
			<tr>
				<td align="center">4</td>
				<td><?=Yii::t('app','device_register')?></td>
				<td class="text-center"><?=Html::a('device.xlxs','example/device.xlsx',['class'=>'']);?></td>
				<td class="text-center"><?=Html::a('<i class="glyphicon glyphicon-import"></i> '.Yii::t('app','import').' Excel',['device'],['class'=>'btn btn-info btn-xs']);?></td>
			</tr>
		</table>


   	 </div>

</div>
