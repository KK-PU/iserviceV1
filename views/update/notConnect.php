<?php
use yii\helpers\Html;

$this->title = 'Check Update New Version';
?>
    <h4><?= Html::encode($this->title) ?></h4>
	
    <hr>
	
	<div class="col-sm-offset-3 col-sm-6">

		<div class="panel panel-danger">
			 <div class="panel-heading"> <?= Html::encode($this->title) ?></div>
				<div class="panel-body">

					<p>- ไม่สามารถ เชื่อมต่อ Internet หรือ Server ได้ โปรดตรวจสอบการเชื่อมต่อเครือข่าย ของคุณ</p>
					
				</div>
		</div>
	</div>