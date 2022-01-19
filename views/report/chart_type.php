<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dektrium\user\models\User;
use app\models\Job;


$this->title = Yii::t('app','maintenance_stat');
?>

<h4><i class="glyphicon glyphicon-stats"></i> <?= Html::encode($this->title) ?></h4>

  <?=$this->render('_menu',['active'=>'chart_type']);?>
<br>
<h4 class="text-center"><?=$title?> <?="&nbsp;".Job::dateThai($start_date)." ".Yii::t('app','to')."  ".Job::dateThai($end_date);?>  </h4>

    <?=$this->render('_search_date_chart',['start_date'=>$start_date,'end_date'=>$end_date,'link'=>'chart-type'])?>


<div class="col-md-12">

<div id="chart"></div>

		<br>

    <table class="table table-bordered report-table">
      <tr>
        <th class='text-center'><?=Yii::t('app','order')?></th>
        <th width="75%"><?= $sub_title?></th>
        <th width="10%" class='text-center'><?=Yii::t('app','number')?></th>
        <th width="10%" class='text-center'><?=Yii::t('app','detail')?></th>
      </tr>
    <?php
        $i = 1;
        $sum = 0;
        foreach($model as $type){
      			if($type['total'] > 0){
      				echo"<tr>";
      					echo"<td class='text-center'>".$i."</td>";
      					echo"<td>".$type['title']."</td>";
      					echo"<td class='text-center'>".$type['total']."</td>";
      					echo "<td class='text-center'>".Html::a(Yii::t('app','detail'),['print-detail','start'=>$start_date,'end'=>$end_date,'type_id'=>$type['id']],['class'=>'btn btn-default btn-xs','target'=>'_blank'])."</td>";
      				echo"</tr>";
              $sum += $type['total'];
      				$i++;
      			}
        }
    ?>
    <tr class="active">
        <td></td>
        <td class='text-right'><b><?=Yii::t('app','total')?></b></td>
        <td class='text-center'><b><?php echo $sum ?></b></td>
        <td class='text-center'><b><?=Yii::t('app','items')?></b></td>
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
