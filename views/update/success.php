<?php
use yii\helpers\Html;

$this->title = 'Success For Update Version '.$version;

?>
    <h4><?= Html::encode($this->title) ?></h4>
    <hr>
<div class="col-sm-offset-3 col-sm-6">

    <div class="panel panel-info">
         <div class="panel-heading"> <?= Html::encode($this->title) ?></div>
            <div class="panel-body">
			
				<p class='alert alert-success'>Update Version <?=$version?> เรียบร้อย</p>
			
			</div>
	</div>
</div>