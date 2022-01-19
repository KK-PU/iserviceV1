<?php
use yii\helpers\Html;
use yii\grid\GridView;
use dektrium\user\models\User;
use app\models\Job;

$this->title = Yii::t('app','performance_report');

?>

<h4><i class="glyphicon glyphicon-stats"></i> <?= Html::encode($this->title) ?></h4>

  <?=$this->render('_menu',['active'=>'job']);?>
    <br>

      <h4 class="text-center"><?= Html::encode($this->title) ?>
        <?=$sub_title?>
        <?="&nbsp; ".Yii::$app->datethai->getDate($start)." ".Yii::t('app','to')." ".Yii::$app->datethai->getDate($end);?>
      </h4>


    <?=$this->render('_search_job',[
      'user_id'=>$user_id,
      'start'=>$start,
      'end'=>$end
    ]);?>

    <?=$this->render('_nav',[
        'user_id'=>$user_id,
        'start'=>$start,
        'end'=>$end
    ]);?>

    <div class="pull-right">

        <?= Html::a('<i class="glyphicon glyphicon-print"></i> '.Yii::t('app','print'),[
                'chart-report',
                'user_id'=>$user_id,
                'start'=>$start,
                'end'=>$end,
        		    'print'=>true
         ],['class'=>'btn btn-default btn-sm','target'=>'_blank'])?>
    </div>

    <div class="col-md-12">

		<br>

	<div id="chart"></div>

		<table class='table table-bordered report-table'>
			<tr>
				<th width="80%"><?=Yii::t('app','job_type')?></th>
				<th width="10%" class="text-center"><?=Yii::t('app','number_of_times')?></th>
				<th width="10%" class="text-center"><?=Yii::t('app','detail')?></th>
			</tr>
			<?php
				$sum = 0;
				if(!empty($model)){

					foreach($model as $r){
						echo "<tr>";
							echo "<td>".$r['type_name_job']."</td>";
							echo "<td class='text-center'>".$r['total']."</td>";

							echo "<td class='text-center'>".Html::a(Yii::t('app','detail'),['print-detail','start'=>$start,'end'=>$end,'user_id'=>$user_id,'job_type_id'=>$r['id']],['class'=>'btn btn-default btn-xs','target'=>'_blank'])."</td>";
						echo "</tr>";
						$sum += $r['total'];
					}
				}
			?>
			<tr class="active">
				<td><b><?php echo Yii::t('app','total') ?></b></td>
				<td class="text-center"><b><?php echo $sum ?></b></td>
				<td></td>
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
