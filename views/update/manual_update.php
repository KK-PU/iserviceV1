<?php
use yii\helpers\Html;

$this->title = 'Download File Update Version '.$version;

?>
    <h4><?= Html::encode($this->title) ?></h4>
    <hr>
<div class="col-sm-offset-3 col-sm-6">

    <div class="panel panel-info">
         <div class="panel-heading"><?= Html::encode($this->title) ?></div>
            <div class="panel-body">
			

				<?=Html::a('Download File Update version '.$version,$link)?>
				
			
			</div>
	</div>
</div>