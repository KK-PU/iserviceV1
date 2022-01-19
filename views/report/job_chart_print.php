<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dektrium\user\models\User;
use app\models\Job;


$this->title = Yii::t('app','performance_report');
?>


<h4 align="center"><?= Html::encode($this->title) ?> <?=$sub_title?></h4>

<p><?="&nbsp; ".Yii::$app->datethai->getDate($start)." ".Yii::t('app','to')." ".Yii::$app->datethai->getDate($end);?> </p>

    <div class="pull-right margin-print" id="non-printable">

        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>

    </div>
    <br>

    <div class="col-md-12">
        <div id="chart"></div>
		<table class='table table-bordered report-table' style="font-size:14px;">
      <tr>
        <th width="90%"><?=Yii::t('app','job_type')?></th>
        <th width="10%" class="text-center"><?=Yii::t('app','number_of_times')?></th>
      </tr>

			<?php
        $sum = 0;
        if(!empty($model)){
            foreach($model as $r){
    					echo "<tr>";
    						echo "<td>".$r['type_name_job']."</td>";
    						echo "<td class='text-center'>".$r['total']."</td>";
    					echo "</tr>";
              $sum += $r['total'];
    				}
        }

			?>
      <tr>
        <td><b><?php echo Yii::t('app','total') ?></b></td>
        <td class="text-center"><b><?php echo $sum ?></b></td>

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
			"'.Yii::t('app','performance_report').'" : "bar",
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
