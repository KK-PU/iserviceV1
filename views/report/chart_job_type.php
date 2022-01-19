<?php
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Job;

$this->title = Yii::t('app','maintenance_stat');
?>

<h4><i class="glyphicon glyphicon-stats"></i> <?= Html::encode($this->title) ?></h4>

    <?=$this->render('_menu',['active'=>'chart_type']);?>

    <br>

	<h4 class="text-center"><?=$title ?> <?="&nbsp; ".Job::dateThai($start_date)."&nbsp;".Yii::t('app','to')."&nbsp;".Job::dateThai($end_date);?> </h4>

    <div class="col-md-12">

        <?=$this->render('_search_date_chart',['start_date'=>$start_date,'end_date'=>$end_date,'link'=>'chart-job-type'])?>

    </div>

    <div class="col-md-12">

		<br>

		  <div id="chart"></div>

      		<table class='table table-bordered report-table'>
      			<tr>
      				<th class='text-center'><?=Yii::t('app','order')?></th>
      				<th width="75%"><?= $sub_title?></th>
      				<th width="10%" class='text-center'><?=Yii::t('app','number')?></th>
      				<th width="10%" class='text-center'><?=Yii::t('app','detail')?></th>
      			</tr>
      			<?php
      				$i = 1;
					    $sum = 0;

              if(!empty($model)){

                  foreach($model as $r){

          					echo "<tr>";
          						echo "<td class='text-center'>".$i."</td>";

          						echo "<td>".$r['title']."</td>";

          						echo "<td class='text-center'>".number_format($r['total'])."</td>";

          						echo "<td class='text-center'>".Html::a(Yii::t('app','detail'),['print-detail','start'=>$start_date,'end'=>$end_date,'job_type_id'=>$r['id']],['class'=>'btn btn-default btn-xs','target'=>'_blank'])."</td>";
          				 echo "</tr>";

                    $sum += $r['total'];

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
