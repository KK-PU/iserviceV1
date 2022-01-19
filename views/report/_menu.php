<?php
use yii\helpers\Html;
?>

<ul class="nav nav-pills" style="margin-top:15px;border-bottom: 1px solid #ccc;">
  <li <?= $active == "job" ? 'class="active"' : ''?>><?= Html::a('<i class="glyphicon glyphicon-tasks"></i> '.Yii::t('app','work_info'),['index'])?></li>

  <?php
    if($active == "device_id" || $active ==  "type_department" || $active ==  "device_name" || $active == "serial_no" || $active == "employee_id"){
       $device_active = true;
    }else{
      $device_active = false;
    }
  ?>

  <li <?= $device_active == true ? 'class="active"' : ''?>><?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> '.Yii::t('app','device_register'),['search-type-department'])?></li>

  <li <?= $active == "cost" ? 'class="active"' : ''?>><?= Html::a('<i class="glyphicon glyphicon-usd"></i> '.Yii::t('app','sum_maintenance'),['cost-department'])?></li>

 <li <?= $active == "device_type_all" ? 'class="active"' : ''?>><?= Html::a('<i class="glyphicon glyphicon-stats"></i> '.Yii::t('app','number_of_device'),['device-type-all'])?></li>
 <li <?= $active == "software_report" ? 'class="active"' : ''?>><?= Html::a('<i class="glyphicon glyphicon-stats"></i> '.Yii::t('app','number_of_software'),['software-report'])?></li>
 <li <?= $active == "chart_type" ? 'class="active"' : ''?> role="presentation" class="dropdown">
       <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents"><i class="glyphicon glyphicon-file"></i><?=Yii::t('app','maintenance_stat')?> <span class="caret"></span></a>
       <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
         <li><?= Html::a('<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','maintenance_job_type'),['chart-job-type'])?></li>
         <li><?= Html::a('<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','maintenance_device_type'),['chart-type'])?></li>
         <li><?= Html::a('<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','maintenance_department'),['chart-department'])?></li>
         <li><?= Html::a('<i class="glyphicon glyphicon-file"></i> '.Yii::t('app','employee_report'),['employee-report'])?></li>
   </ul>
 </li>
</ul>

<?php
$this->registerJs("
	$(function(){
		$('#report').addClass('active');
	});
");
?>
