<?php
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\grid\GridView;
use dektrium\user\models\User;
use app\models\Job;

$this->title = "Print Report";
?>

  <h4 class="text-center"><?=$title?></h4>

  <p><?="&nbsp; ".Yii::$app->datethai->getDate($start_date)." ".Yii::t('app','to')." ".Yii::$app->datethai->getDate($end_date);?>  </p>

    <div class="pull-right" id="non-printable">

        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i>&nbsp;<?=Yii::t('app','Print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i>&nbsp;<?=Yii::t('app','Close')?></button>

    </div>
<br>


    <div class="col-md-12">
		<br>
	<div id="chart"></div>

		<table class='table table-bordered report-table'>
			<tr>
				<th class='text-center'>#</th>
				<th width="85%"><?=$sub_title?></th>
				<th width="10%" class='text-center'><?=Yii::t('app','number')?></th>
			</tr>
			<?php
				$i = 1;
				  $sum = 0;
					if(!empty($model)){

					  foreach($model as $r){
								if($r['total'] > 0){
									echo "<tr>";
										echo "<td class='text-center'>".$i."</td>";
										echo "<td>".$r['title']."</td>";
										echo "<td class='text-center'>".number_format($r['total'])."</td>";

									echo "</tr>";

									$sum += $r['total'];

									$i++;
								}
							}
					}

			?>
			<tr class="active">
				  <td></td>
				  <td class='text-right'><b><?=Yii::t('app','total')?></b></td>
				  <td class='text-center'><b><?php echo $sum ?></b></td>

			  </tr>
		</table>

    </div>

<?php

$this->registerJs('

var json_labels = '.json_encode($labels).';

var json_data = '.json_encode($data).';

var w3 = c3.generate({
	data:{
	columns:[
			json_data,
		],
		types:{
			"'.Yii::t('app','maintenance_stat').'" : "bar",
		}
	},
	color:{
	  pattern: ["#22B14C", "#ff7f0e", "#ff7f0e", "#ffbb78", "#2ca02c", "#98df8a", "#d62728"],
	},
	axis:{
	x:{
		type:"category",
		categories: json_labels,
	label:{
		text:"",
		position:"outer-middle"}
	},
}

});

');

?>
