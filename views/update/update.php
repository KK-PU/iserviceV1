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
			
				<p > Version ปัจจุบันของคุณ คือ <?=$current_version?></p>
				
				<p > Version ล่าสุด ของระบบ  คือ <?=$data['version']?></p>
				
				<hr>
				<?= Html::a("Install Update File To Version ".$data['version'],['extract-file','update'=>'install','v'=>$data['version'],'filename'=>$data['file']],['class'=>'btn btn-warning btn-sm']);?>
			</div>
	</div>
</div>