<?php
use yii\helpers\Html;

$this->title = 'Check Update Version';
?>
    <h4><?= Html::encode($this->title) ?></h4>
    <hr>
	
	<div class="col-sm-offset-3 col-sm-6">

		<div class="panel panel-info">
			 <div class="panel-heading"> <?= Html::encode($this->title) ?></div>
				<div class="panel-body">
					
					<p class="text text-primary"> Version ปัจจุบันของคุณ คือ <?=$current_version?></p>
					<hr>
					<?= Html::a('Check For Update Version',['update'],['class'=>'btn btn-success btn-sm'])?>
				</div>
		</div>
	</div>