<?php
use yii\helpers\Html;

$this->title = Yii::t('app','summary_software');
?>

  <h4 class="text-center"><?= Html::encode($this->title) ?></h4>




	<div class="container">
    <div class="pull-right" id="non-printable" style="padding-bottom:20px">

        <button class="btn btn-info btn-sm" onclick="return window.print();"><i class="glyphicon glyphicon-print"></i> <?=Yii::t('app','print')?></button>
        <button class="btn btn-default btn-sm" onclick="return window.close();"><i class="glyphicon glyphicon-off"></i> <?=Yii::t('app','close')?></button>

    </div>
		<div class="col-md-12">

			  <table class='table'>
				<?php
				  if(!empty($software)){

					foreach($software as $k => $v){
						echo "<tr class='active'>";

						echo "<th>".$k."</th>";
						echo "<th></th>";
						echo "</tr>";
						  foreach($v as $s){
							echo "<tr>";
							  echo "<td style='text-indent:30px;'>".$s['software_name']."</td>";
							  echo "<td>".$s['total_install']."</td>";
							echo "</tr>";
						  }
					}

				  }
				?>
			  </table>

		</div>
	</div>
