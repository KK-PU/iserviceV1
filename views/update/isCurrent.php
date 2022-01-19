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
				<p>Last Version <?= $current_version?> </p>
				
				<p class="text text-info"> ระบบของคุณ  ได้ Update เป็น Version ล่าสุดอยู่แล้ว</p>

			</div>
	</div>
</div>