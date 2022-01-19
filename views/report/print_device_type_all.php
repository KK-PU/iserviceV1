<?php
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Job;

$this->title = Yii::t('app','summary_device');
?>

  <h4 class="text-center"><?= Html::encode($this->title) ?></h4>

      <div class="pull-right" id="non-printable">

        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>

    </div>

	<br>

		<div class="col-md-12">
			<div class="row">
				<div id="chart"></div>
			</div>
				<br>
        		<table class='table table-bordered report-table' width="100%" style="font-size:14px;">
        			<tr>
        				<th width="90%"><?=Yii::t('app','device_type')?></th>
        				<th width="10%" class="text-center"><?=Yii::t('app','number')?></th>
        			</tr>

        			<?php
                if(!empty($model)){

                    $sum = 0;

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
                  <td class='text-center'><b><?php echo number_format($sum)?></b></td>
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
