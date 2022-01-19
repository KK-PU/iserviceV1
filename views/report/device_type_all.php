<?php
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\grid\GridView;
use dektrium\user\models\User;
use app\models\Job;

$this->title = Yii::t('app','summary_device');
?>

<h4><i class="glyphicon glyphicon-stats"></i> <?= Html::encode($this->title) ?></h4>

    <?=$this->render('_menu',['active'=>'device_type_all']);?>

	<br>

  <h4 class="text-center"><?=Yii::t('app','summary_device')?></h4>
	   <div class="pull-right">
			<?=Html::a("<i class='glyphicon glyphicon-print'></i> ".Yii::t('app','print'),['device-type-all','print'=>true],['class'=>'btn btn-default btn-sm','target'=>'_blank'])?>
	   </div>
    <div class="col-md-12">
		<br>
	   <div id="chart"></div>

    		<table class='table table-bordered report-table'>
    			<tr>
    				<th width="80%"><?=Yii::t('app','device_type')?></th>
    				<th width="10%" class="text-center"><?=Yii::t('app','number')?></th>
    			</tr>
    			<?php
            $sum = 0;
            if(!empty($model)){

        				foreach($model as $r){
        					echo "<tr>";
        						echo "<td>".$r['device_type']."</td>";
        						echo "<td class='text-center'>".$r['total']."</td>";

        					echo "</tr>";
                  $sum += $r['total'];
        				}
            }
    			?>
          <tr class="active">
              <td class='text-left'><b><?=Yii::t('app','total')?></b></td>
              <td class='text-center'><b><?php echo number_format($sum) ?></b></td>
          </tr>
    		</table>
        
  </div>

<?php

$this->registerJs('

var json_labels = '.json_encode($labels).';

var json_data = '.json_encode($data).';

var w3 = c3.generate({
	data:{

	columns:json_data,
		types:json_labels,
	},
	color:{
	     pattern: ["#1f77b4", "#aec7e8", "#ff7f0e", "#ffbb78", "#2ca02c", "#98df8a", "#d62728", "#ff9896", "#9467bd", "#c5b0d5", "#8c564b", "#c49c94", "#e377c2", "#f7b6d2", "#7f7f7f", "#c7c7c7", "#bcbd22", "#dbdb8d", "#17becf", "#9edae5"]
},
	axis:{
	x:{
		type:"category",
		categories:["สรุป จำนวน อุปกรณ์ทั้งหมด"],

		//categories: json_labels,
	label:{
		text:"",
		position:"outer-middle"}
	},
}

});

');

?>
